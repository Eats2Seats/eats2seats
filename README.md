# Installation Guide

1. Install [Docker Desktop](https://docs.docker.com/get-docker/) following the guide for your specified operating system.
    - If you're using Windows 10 you should install Docker Desktop with the [Windows Subsystem Linux 2](https://docs.docker.com/docker-for-windows/wsl/) (WSL 2) backend. This is optional, however you will realize significant performance gains by doing so.
    - If you choose to use the Docker Desktop WSL 2 backend we suggest utilizing the latest distribution of Ubuntu ([20.04](https://www.microsoft.com/store/apps/9n6svws3rx71) at the time of writing this).
2. [Install Composer](https://getcomposer.org/download/) globally via one of the installation options.
3. Clone the [GitHub repository](https://github.com/Eats2Seats/Eats2Seats) to your local machine's development environment. If you are utilizing WSL 2 you must clone the repository must reside within the WSL 2 filesystem.

    ```bash
    git clone https://github.com/Eats2Seats/Eats2Seats.git 
    ```

4. [Install PHP](https://www.php.net/manual/en/install.php) with the `mb-string` and `dom` extensions.

    ```bash
    sudo apt install php php-mbstring php-dom
    ```

5. [Install Composer](https://getcomposer.org/download/) using your preferred installation method from the attached guide.
6. [Install Laravel Sail](https://laravel.com/docs/8.x/sail#installing-sail-into-existing-applications) via Composer as a development dependency.

    ```bash
    composer require laravel/sail --dev
    ```

7. Configure a [bash alias](https://laravel.com/docs/8.x/sail#configuring-a-bash-alias) for Laravel Sail in your `~/.bashrc` or `~/.zshrc` file.

    ```bash
    alias sail='bash vendor/bin/sail'
    ```

8. [Start Laravel Sail](https://laravel.com/docs/8.x/sail#starting-and-stopping-sail) and allow Docker time to build the required containers.

    ```bash
    sail up -d
    ```

9. Copy the `.env.example` file to a `.env` file.

    ```bash
    cp .env.example .env
    ```

10. Generate an `APP_KEY`.

    ```bash
    sail artisan key:generate
    ```

11. Navigate to [http://localhost](http://localhost) in your browser to view the web application.
