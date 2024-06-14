<?php

require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

function downloadBlob($connectionString, $containerName, $blobName, $downloadPath) {

    // Crear el cliente de Blob
    $blobClient = BlobRestProxy::createBlobService($connectionString);

    try {
        // Obtener el blob
        $blob = $blobClient->getBlob($containerName, $blobName);

        // Guardar el contenido del blob en un archivo local
        $content = stream_get_contents($blob->getContentStream());

        file_put_contents($downloadPath, $content);
        
        echo "Archivo descargado exitosamente: " . $downloadPath . PHP_EOL;
        
    } catch (ServiceException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo "Error al descargar el blob: " . $code . " - " . $error_message . PHP_EOL;
    }
}

function uploadBlob($connectionString, $containerName, $blobName, $filePath) {
    // Crear el cliente de Blob
    $blobClient = BlobRestProxy::createBlobService($connectionString);

    try {
        // Leer el contenido del archivo
        $content = fopen($filePath, "r");
        
        // Opciones adicionales
        $options = new CreateBlockBlobOptions();
        $options->setContentType(mime_content_type($filePath));

        // Subir el blob
        $blobClient->createBlockBlob($containerName, $blobName, $content, $options);
        
        echo "Archivo subido exitosamente: " . $blobName . PHP_EOL;
    } catch (ServiceException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo "Error al subir el blob: " . $code . " - " . $error_message . PHP_EOL;
    }
}

    // Configura tu cadena de conexión y los detalles del blob
    $connectionString = "TU_CADENA";
    $containerName = "TU_CONTENEDOR";
    $blobName = "a.txt";
    $filePath = "./descargas/a.txt";

    // Llama a la función para descargar el blob
    downloadBlob($connectionString, $containerName, $blobName, $filePath);

    return ;

?>