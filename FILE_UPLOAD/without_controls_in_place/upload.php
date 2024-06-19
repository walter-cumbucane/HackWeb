<?php

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit("POST request method required");
    }  

    if (empty($_FILES)) {
        exit("$_FILES is empty. Is file_uploads set to off in php_ini?");
    }

    if($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {

        switch($_FILES["fileToUpload"]["error"]) {

            case UPLOAD_ERR_PARTIAL:
                exit("File uploaded only partially");
                break;
            case UPLOAD_ERR_NO_FILE:
                exit("No file was uploaded");
                break;
            case UPLOAD_ERR_EXTENSION:
                exit("File upload stopped by a PHP extension");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                exit("Can't write file");
                break;
            default:
                exit("Unkown upload error");
                break;
        }
    } 

    /*
    $mime_types = ["image/gif", "image/png", "image/jpeg"];

    if (! in_array($_FILES["fileToUpload"]["type"], $mime_types)) {
        exit("Only images allowed");
    }
    */

    $filename = $_FILES["fileToUpload"]["name"];
    $destination = __DIR__ . "/uploads/" . $filename;

    if (! move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destination)) {
        exit("Can't move uploaded file");
    }
    else {
        header("Location: index.html");
    }

   

?>

