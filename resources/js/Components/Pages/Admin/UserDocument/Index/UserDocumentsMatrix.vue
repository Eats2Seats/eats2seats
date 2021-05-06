<template>
    <matrix
        :data="user_documents"
        :route="route('admin.user-documents.index')"
        class="shadow"
        v-slot="{ rowsSelected }"
    >
        <div class="flex flex-row justify-between items-center p-6 border-b border-gray-200">
            <h2 class="font-serif font-bold text-4xl text-gray-700">
                User Documents
            </h2>
            <div class="flex flex-row items-center items-stretch space-x-4">
                <matrix-filter-search
                    field="user_first_name"
                    instant
                />
                <matrix-filter-menu
                    title="Filter Documents"
                    margin-adjustment="ml-0"
                >
                    <matrix-filter-select field="review_status">
                        Status
                    </matrix-filter-select>
                    <matrix-filter-date field="submitted">
                        Submitted
                    </matrix-filter-date>
                    <matrix-filter-date field="reviewed">
                        Reviewed
                    </matrix-filter-date>
                </matrix-filter-menu>
            </div>
        </div>
        <matrix-table>
            <matrix-head>
                <matrix-head-cell field="user_first_name">
                    First Name
                </matrix-head-cell>
                <matrix-head-cell field="user_last_name">
                    Last Name
                </matrix-head-cell>
                <matrix-head-cell field="review_status">
                    Status
                </matrix-head-cell>
                <matrix-head-cell field="liability_file">
                    Liability Waiver
                </matrix-head-cell>
                <matrix-head-cell field="tax_file">
                    W-9 Tax Form
                </matrix-head-cell>
                <matrix-head-cell field="submitted">
                    Submitted
                </matrix-head-cell>
                <matrix-head-cell field="reviewed">
                    Reviewed
                </matrix-head-cell>
                <matrix-head-cell>
                    <span class="sr-only">Actions</span>
                </matrix-head-cell>
            </matrix-head>
            <matrix-body v-slot="{ row }">
                <matrix-body-cell field="user_first_name">
                    {{ row.user_first_name }}
                </matrix-body-cell>
                <matrix-body-cell field="user_last_name">
                    {{ row.user_last_name }}
                </matrix-body-cell>
                <matrix-body-cell field="review_status" class="capitalize">
                    {{ row.review_status }}
                </matrix-body-cell>
                <matrix-body-cell field="liability_file">
                    <a
                        :href="row.liability_file"
                        target="_blank"
                        class="font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                    >
                        View document
                    </a>
                </matrix-body-cell>
                <matrix-body-cell field="tax_file">
                    <a
                        :href="row.tax_file"
                        target="_blank"
                        class="font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                    >
                        View document
                    </a>
                </matrix-body-cell>
                <matrix-body-cell field="submitted">
                    {{ row.submitted }}
                </matrix-body-cell>
                <matrix-body-cell field="reviewed">
                    {{ row.reviewed }}
                </matrix-body-cell>
                <matrix-body-cell>
                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            class="group"
                            @click="approveDocumentPair(row.id)"
                        >
                            <check-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600"/>
                        </button>
                        <button
                            type="button"
                            class="group"
                            @click="openRejectModal(row.id)"
                        >
                            <x-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600"/>
                        </button>
                    </div>
                </matrix-body-cell>
            </matrix-body>
        </matrix-table>
        <div class="flex flex-row items-center items-stretch p-6 space-x-4 border-t border-gray-200">
            <matrix-column-visibility>
                <matrix-column-visibility-item field="review_status">
                    Status
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="liability_file">
                    Liability Waiver
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="tax_file">
                    W-9 Tax Form
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="submitted">
                    Submitted
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="reviewed">
                    Reviewed
                </matrix-column-visibility-item>
            </matrix-column-visibility>
            <matrix-pagination/>
        </div>
    </matrix>
    <modal ref="rejectModal">
        <template #title>
            Reject Users Documents
        </template>
        <template #description>
            <label
                for="reject-reason"
                class=""
            >
                Reason for Rejection <span class="text-red-600">*</span>
            </label>
            <textarea
                name="reject-reason"
                id="reject-reason"
                cols="30"
                rows="3"
                class="mt-2 w-full"
                v-model="rejectMessage"
            ></textarea>
            <p
                v-if="rejectErrors?.review_message"
                class="mt-1 font-sans font-normal text-sm text-red-600"
            >
                {{ rejectErrors?.review_message }}
            </p>
        </template>
        <template #button>
            <x-button
                class="!bg-red-500 !text-white !border-none hover:!bg-red-600"
                @click="rejectDocumentPair"
            >
                Reject
            </x-button>
        </template>
    </modal>
</template>

<script>
import Matrix from "@/Components/Matrix/Matrix";
import MatrixTable from "@/Components/Matrix/MatrixTable";
import MatrixHead from "@/Components/Matrix/MatrixHead";
import {inject, ref} from "vue";
import MatrixHeadCellSelect from "@/Components/Matrix/MatrixHeadCellSelect";
import MatrixHeadCell from "@/Components/Matrix/MatrixHeadCell";
import MatrixBody from "@/Components/Matrix/MatrixBody";
import MatrixBodyCellSelect from "@/Components/Matrix/MatrixBodyCellSelect";
import MatrixBodyCell from "@/Components/Matrix/MatrixBodyCell";
import {CheckIcon, XIcon} from "@heroicons/vue/outline/esm";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
import MatrixFilterDate from "@/Components/Matrix/MatrixFilterDate";
import MatrixRowAction from "@/Components/Matrix/MatrixRowAction";
import MatrixRowActionItem from "@/Components/Matrix/MatrixRowActionItem";
import {Inertia} from "@inertiajs/inertia";
import Modal from "@/Components/General/Modal";
import XButton from "@/Components/General/XButton";
import MatrixColumnVisibility from "@/Components/Matrix/MatrixColumnVisibility";
import MatrixColumnVisibilityItem from "@/Components/Matrix/MatrixColumnVisibilityItem";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
export default {
    name: 'UserDocumentsMatrix',
    components: {
        MatrixPagination,
        MatrixColumnVisibilityItem,
        MatrixColumnVisibility,
        XButton,
        Modal,
        MatrixRowActionItem,
        MatrixRowAction,
        MatrixFilterDate,
        MatrixFilterSelect,
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixBodyCell, CheckIcon, XIcon,
        MatrixBodyCellSelect, MatrixBody, MatrixHeadCell, MatrixHeadCellSelect, MatrixTable, MatrixHead, Matrix
    },
    props: {
        user_documents: {
            type: Object,
            required: true,
        }
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        // Define function to approve single user document pair
        const approveDocumentPair = (id) => {
            Inertia.put(route('admin.user-documents.update', {id: id}), {
                review_status: 'approved',
                review_message: null,
            }, {
                preserveState: true,
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                }
            });
        }

        // Define reactive variables for tracking reject modal state
        const rejectModal = ref(null);
        const rejectId = ref(null);
        const rejectMessage = ref(null);
        const rejectErrors = ref(null);

        // Define function to manage reject modal state
        const openRejectModal = (id) => {
            // Reset modal state
            rejectId.value = id;
            rejectMessage.value = null;
            // Open modal
            rejectModal.value.setIsOpen(true);
        }

        // Define function to reject single user document pair
        const rejectDocumentPair = () => {
            Inertia.put(route('admin.user-documents.update', {id: rejectId.value}), {
                review_status: 'rejected',
                review_message: rejectMessage.value,
            }, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    rejectModal.value.setIsOpen(false);
                },
                onError: (errors) => {
                    rejectErrors.value = errors;
                }
            });

        }

        return {
            route,
            approveDocumentPair,
            rejectModal,
            rejectMessage,
            rejectErrors,
            openRejectModal,
            rejectDocumentPair,
        };
    },
}
</script>

<style scoped>

</style>
