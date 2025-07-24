## Step 1: Download Xampp and Composer from these links
    1. https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe
    2. Command line installation of composer:
       a. php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
       b. php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
       c. php composer-setup.php
       d. php -r "unlink('composer-setup.php');"

## Step 2: Add Xampp, PHP to your Environment variables
    <img width="686" height="654" alt="image" src="https://github.com/user-attachments/assets/0d72e484-c23a-44e7-8cac-d57dfab29c60" />

## Step 3: Navigate to C:/xampp/htdocs and Open it in VScode 
    Clone this within that folder: "https://github.com/AJCarmichael/fpms.git" 
        
## Step 4: Ensure your environment variables are correct. (port number)
    <img width="550" height="154" alt="image" src="https://github.com/user-attachments/assets/259d4208-3263-4bf7-9d95-fa520db50b15" />
    
## Step 5: Run the following command in the VSCode terminal while xampp mysql is runnning:
    php artisan migrate
    
## Step 6: Go into the MySQL shell within xampp and run the following:
    <img width="1229" height="753" alt="image" src="https://github.com/user-attachments/assets/e662c0b7-162e-4919-a63e-1d3938758ba0" />

    a. mysql -u root
    b. use fpms;
    c. INSERT INTO users (id, name, username, email, email_verified_at, password, privileges, remember_token, created_at, updated_at, usertype) VALUES (1, 'Admin', 'admin', 'admin@example.com', NULL, '$2y$12$8U20OAX8jvBEg/ZFXvIFxe5lG852SACq3QB6h/XMOLYNyWIjVGHBm', '', NULL, '2025-03-16 15:05:18', '2025-03-16 15:05:18', 'admin');
    d. Close the MySQL terminal

## Step 7: Run the following command:
    php artisan serve
