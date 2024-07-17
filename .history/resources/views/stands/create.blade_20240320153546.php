@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-empresa">
        <div class="card-header">
            <h3 class="titulo">CREAR STANDS</h3>
            <img class="logo-visitados" src="{{ asset('images/logoStand.png') }}" alt="">
        </div>
        <div class="card-body">
            <form id="stand-form" action="{{ route('stand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Campo para el nombre del stand -->
                <div class="input-group mb-3">
                    <input type="text" id="input-empresa" name="name" required placeholder="Nombre Stand">
                </div>
                
                 <select id="evento_id" name="evento_id">
                    <option value="" selected disabled>Selecciona un evento</option>
                    @foreach($event as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->name }}</option>
                    @endforeach
                </select>
                <label id="numero-imagenes-label">3</label>

<!--                 
                <div id="numero-imagenes-container" style="display: none;"> -->
           
                
            </label>
            </div>
           
                <select id="place_id" name="place_id">
            
                <option value="">Selecciona un lugar</option>
                </select> 
               
                  <!-- Campo para cargar el logo -->
                  <div class="mb-3">
                            <label for="logo" class="form-label label-register">Logo URL</label>
                            <input type="file" class="form-control input-register" name="logo" accept="image/*" required>
                        </div>

                <!-- Campo para cargar el banner -->
                <div class="mb-3">
                            <label for="banner" class="form-label label-register">Banner URL</label>
                            <input type="file" class="form-control input-register" name="banner" accept="image/*" required>
                        </div>

                <!-- Campo para la descripción -->
                <div class="form-floating">
                    <h5>Información del stand</h5>
                    <textarea id="input-empresas" name="description" style="height: 100px" required></textarea>
                </div>

                <!-- Campos para las redes sociales -->
                <div id="networking">
                    <a id="link-google" href="{{ route('login-google') }}"> 
                    <img src="http://127.0.0.1:8000/images/Facebookk.png" alt="" class="google" style="width: 20px;height: auto;margin-top: -5px;margin-left: -24px;">                    </a>
                <div id="networking">
                    <a id="link-google" href="{{ route('login-google') }}"> 
                    <img src="http://127.0.0.1:8000/images/Facebookk.png" alt="" class="google" style="width: 20px;height: auto;margin-top: -49px;margin-left: -3px;">                    </a>
                <div id="networking">
                    <a id="link-google" href="{{ route('login-google') }}"> 
                    <img src="http://127.0.0.1:8000/images/Facebookk.png" alt="" class="google" style="width: 20px;height: auto;margin-top: -94px;margin-left: 20px;">                    </a>
                    <div class="input-group mb-3">
                    <input type="text" id="inputs-empresas" name="name" required placeholder="Sitio web">
                </div>
                </div>
                
                <!-- Campo para seleccionar el primer color del stand -->
                <div class="mb-3">
                    <h5>Seleccione los colores del stand</h5>
                    <label for="color_contenedor_1" class="form-label label-register">Color de fondo</label>
                    <input type="color" id="color_contenedor_1" class="form-control input-register" name="color_contenedor_1" value="#000000">
                    <small>Seleccione el color de fondo.</small>
                </div>

                <!-- Campo para seleccionar el segundo color del stand -->
                <div class="mb-3">
                    <label for="color_contenedor_2" class="form-label label-register">Color de letras</label>
                    <input type="color" id="color_contenedor_2" class="form-control input-register" name="color_contenedor_2" value="#ffffff">
                    <small>Seleccione el color de las letras.</small>
                </div>
                <hr>
               
                <h5>Seleccione las imágenes  para añadir al carrusel</h5>
            <!-- <div class="d-flex flex-wrap justify-content-start" id="image-upload-container">
                
                <div class="input-group mb-3">
                    <label for="image1" class="label-register"></label>
                    <input type="file" class="form-control input-register image-input" id="image1" name="images1" accept="image/*" required>
                    <button type="button" class="btn btn-danger delete-image">Eliminar</button> 
                </div> 
                <div class="d-flex flex-wrap justify-content-start" id="image-upload-container">
   
                <input type="button" class="btn btn-primary add-image" id="add-image-btn" value="Agregar más imágenes" title="Limite de carga: 10 imágenes por sesión.">
            
            </div>
            
            <div class="mb-3 custom-class-name" id="image-container-template" style="display: none;">
            <label class="label-register"></label>
            <input type="file" class="form-control input-register image-input" accept="image/*">
         </div> -->
                <div class="d-flex flex-wrap justify-content-start" id="image-upload-container">
            <div class="input-group mb-3">
                <label for="image1" class="label-register"></label>
                <input type="file" class="form-control input-register image-input" id="image1" name="images1" accept="image/*" required>
                <button type="button" class="btn btn-danger delete-image">Eliminar</button> 
            </div> 
            <div class="mb-3 custom-class-name" id="image-container-template" style="display: none;">
                <label class="label-register"></label>
                <input type="file" class="form-control input-register image-input" accept="image/*">
            </div>
            <input type="button" class="btn btn-primary add-image" id="add-image-btn" value="Agregar más imágenes" title="Limite de carga: 10 imágenes por sesión.">
        </div>

          
               
            <!-- Vista previa del stand -->
            <div class="mb-5">
                <h5 style="margin-top: 30px;">Vista Previa del Stand</h5>
                <div id="preview-stand" class="preview-stand p-3 rounded" style="border: 2px solid #000; background-color: #ffffff; color: #000000; height: 400px;margin-top: 40px;">
                    <h3 class="text-center mb-3">Nombre del Stand</h3>
                    <!-- Logo centrado -->
                    <div class="text-center mb-3">
                        <span class="sr-only">Logo del Stand</span>
                    </div>
                    <!-- Banner más abajo con efecto de desplazamiento -->
                    <div class="text-center mb-3">
                        <span id="banner-preview" style="max-width: 80%; display: block; margin: 0 auto 20px; animation: slideBanner 10s linear infinite;">Banner del Stand</span>
                    </div>
                    <!-- Descripción -->
                    <p class="mb-3">Descripción del Stand...</p>
                    
        <!-- Carrusel de imágenes -->
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <h5 class="text-center">Carrusel</h5>
                </div>
                <div class="carousel-item">
                <h5 class="text-center">Carrusel</h5>
                </div>
                <!-- Agrega más elementos carousel-item según sea necesario -->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        <!-- Redes sociales -->
        <div class="d-flex justify-content-between">
            <!-- Miniatura de Facebook -->
            <div class="thumbnail-container">
            <img src="{{ asset('images/instagram-icon.png') }}">
            <span class="thumbnail-label"></span>
            </div>
            <!-- Miniatura de Instagram -->
            <div class="thumbnail-container">
                <img src="{{ asset('images/instagram-icon.png') }}">
                <span class="thumbnail-label"></span>
            </div>
            <!-- Miniatura de TikTok -->
            <div class="thumbnail-container">
                <img src="{{ asset('images/instagram-icon.png') }}">
                <span class="thumbnail-label"></span>
            </div>
            <!-- Miniatura de Sitio Web -->
            <div class="thumbnail-container">
                <img src="{{ asset('images/instagram-icon.png') }}">
                <span class="thumbnail-label"></span>
            </div>
        </div>
    </div>
</div>


                <!-- Botones para enviar y volver -->
                <div class="row text-center">
                    <div class="col">
                        <button type="submit" class="btn btn-primary mt-3" id="btn-submit">Enviar</button>
                        <a href="{{ route('stand.index') }}" class="btn btn-primary mt-3" id="btn">Volver</a>
                     </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 
 <script>



let imageCounter = 1;
const container = document.getElementById("image-upload-container");
        const carouselInner = document.getElementById("carouselInner");
        const template = document.getElementById("image-container-template");
        const addButton = document.getElementById("add-image-btn");
        // const maxImages = 0;
        let maxImages = 0;
        addButton.addEventListener("click", function () {
            
            if (container.childElementCount < maxImages) {
                const newImageContainer = template.cloneNode(true);
                newImageContainer.style.display = "block";
                container.appendChild(newImageContainer);
 

                
                const imageInput = newImageContainer.querySelector(".image-input");
                const count = container.querySelectorAll(".input-group").length;
                  // Asignar nombre único al campo de entrada de imagen
        const imageInput = newImageContainer.querySelector(".image-input");
        const imageName = "images" + (imageCounter + 1); // Nombre secuencial
        imageInput.name = imageName;
        
        container.appendChild(newImageContainer);

       // Incrementar el contador de imágenes
       imageCounter++;
            
            }
        });

         // Evento change en los campos de carga de imágenes
        container.addEventListener('change', function (event) {
            const imageInput = event.target;
            if (imageInput && imageInput.classList.contains('image-input')) {
                addImageToCarousel(imageInput);
            }
        });
        const eventoId = document.getElementById('evento_id');
        eventoId.addEventListener('change', function (event) {
            const selectedOption = eventoId.options[eventoId.selectedIndex];
            maxImages = parseInt(selectedOption.getAttribute('data-numero-imagenes'));
        });
</script>  -->
<script>
    let imageCounter = 1;
    const container = document.getElementById("image-upload-container");
    const addButton = document.getElementById("add-image-btn");
    
    // Obtén el div "numero-imagenes-label" y extrae el número del contenido
    const numeroImagenesLabel = document.getElementById("numero-imagenes-label");
    let maxImages = parseInt(numeroImagenesLabel.textContent.trim());

    addButton.addEventListener("click", function () {
        if (container.childElementCount < maxImages) {
            const newImageContainer = document.createElement("div");
            newImageContainer.classList.add("input-group", "mb-3");
            
            const label = document.createElement("label");
            label.setAttribute("for", `image${imageCounter}`);
            label.classList.add("label-register");
            label.textContent = `Imagen ${imageCounter}:`;
            newImageContainer.appendChild(label);
            
            const input = document.createElement("input");
            input.setAttribute("type", "file");
            input.classList.add("form-control", "input-register", "image-input");
            input.setAttribute("id", `image${imageCounter}`);
            input.setAttribute("name", `images${imageCounter}`);
            input.setAttribute("accept", "image/*");
            input.setAttribute("required", true);
            newImageContainer.appendChild(input);
            
            const deleteButton = document.createElement("button");
            deleteButton.setAttribute("type", "button");
            deleteButton.classList.add("btn", "btn-danger", "delete-image");
            deleteButton.textContent = "Eliminar";
            deleteButton.addEventListener("click", function () {
                container.removeChild(newImageContainer);
                imageCounter--;
            });
            newImageContainer.appendChild(deleteButton);
            
            container.appendChild(newImageContainer);
            imageCounter++;
        } else {
            alert(`Solo se permiten subir ${maxImages} imágenes.`);
        }
    });
</script>



<script>
    const event = document.getElementById('evento_id');
const place = document.getElementById('place_id');
const numeroImagenesMostrado = document.getElementById('numero-imagenes-label');

event.addEventListener('change', async (e) => {
    const response = await fetch(`/evento/${e.target.value}`);
    const data = await response.json();

    // Limpiar opciones existentes
    place.innerHTML = '<option value="">Selecciona un lugar</option>';

    // Construir opciones para el select de lugares
    data.places.forEach(element => {
        const option = document.createElement('option');
        option.value = element.id;
        option.textContent = element.name;
        place.appendChild(option);
    });

    // Mostrar solo el número de imágenes en el label
    numeroImagenesMostrado.textContent = data.numero_imagenes;
    document.getElementById('numero_imagenes_container').style.display = 'block'; // Mostrar el contenedor
});

</script>


@endsection
