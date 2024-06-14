<?php

require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

// Crear el cliente de Blob
$blobClient = BlobRestProxy::createBlobService($connectionString);

/////SUBIR////////////////////////////////////////////////////////////////////////////

// Configurar opciones adicionales si es necesario
$options = new CreateBlockBlobOptions();

// Subir el archivo
$content = fopen($filePath, "r");
$blobClient->createBlockBlob($containerName, $blobName, $content, $options);
fclose($content);

/////////////////////////////////////////////////////////////////////////////////////

/////DESCARGAR//////////////////////////////////////////////////////////////////////
$blob = $blobClient->getBlob($containerName, $blobName);

// Guardar el contenido del blob en un archivo local
$content = stream_get_contents($blob->getContentStream());
file_put_contents($downloadPath, $content);
///////////////////////////////////////////////////////////////////////////////////