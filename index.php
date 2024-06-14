<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blobs PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="row p-4">
        <div class="col-12">
            <h3 class="mb.2">Formulario</h3>
        </div>
        <div class="col-5">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <label for="archivo">Archivo</label>
                        <input id="inp_file" type="file" class="form-control">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success mt-2" onclick="cargarArchivo()">
                            Cargar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        async function cargarArchivo(){

            try {

                const body = new FormData()
                const inp_file = document.getElementById("inp_file")

                body.append("file", inp_file.files[0])
                
                const res = await fetch('subir.php', {
                    method: "POST",
                    body
                })

                const json = await res.text()

                alert(json)

            } catch (error) {
                console.log(error)
            }

        }

    </script>

</body>
</html>