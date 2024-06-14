<?php

require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

function uploadBlob($connectionString, $containerName, $blobName, $filePath) {

    // Crear el cliente de Blob
    $blobClient = BlobRestProxy::createBlobService($connectionString);

    try {
        // Configurar opciones adicionales si es necesario
        $options = new CreateBlockBlobOptions();

        // Subir el archivo
        $content = fopen($filePath, "r");
        $blobClient->createBlockBlob($containerName, $blobName, $content, $options);
        fclose($content);

        return true;

    } catch (ServiceException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo "Error al subir el blob: " . $code . " - " . $error_message . PHP_EOL;
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Información del archivo subido
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];

        // Configura tu cadena de conexión
        $connectionString = "TU_CADENA";
        $containerName = "TU_CONTENEDOR";

        // Llama a la función para subir el archivo
        $uploadResult = uploadBlob($connectionString, $containerName, $fileName, $fileTmpPath);

        if ($uploadResult) {
            echo json_encode(['status' => 'success', 'message' => 'Archivo subido exitosamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al subir el archivo.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se recibió ningún archivo o hubo un error en la subida.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>
