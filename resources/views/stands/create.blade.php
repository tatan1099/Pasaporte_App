@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="createStandEmpresa">
                    <div class="card-body2create">
            <br>  
            
            <div class="containerimgtitle">
            <img class="logo-createStand d-block" src="{{ asset('images/logoStand.png') }}" alt="">
            <span class="StandCreate d-inline-block">STAND</span>
            </div>
            <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                    <div class="alert alert-success" role="alert" style="position: relative;">
                        <span id="success-message"></span>
                    </div>
                </div>
                @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showSuccessMessage('{{ session('success') }}');
                    });
                </script>
                @endif
                @if(session('error'))
                <div id="error-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: block; z-index: 9999;">
                    <div class="alert alert-danger" role="alert" style="position: relative;">
                        <span id="error-message">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            <br>
            <br>
            
                    <form id="stand-form" action="{{ route('stand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                            <div class="inputscrearstand">
                    <div class="formulario rounded col-md-8 ">
                        <input type="text" name="name" class="form-controlstand form-control" id="name" required 
                        placeholder="Nombre Stand" id="name" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    
                    </div>   


                        <!-- por favor no quitar el siguiente label, es muy necesario en el proyecto   -->
                        <label id="numero-imagenes-label">Número de imágenes</label>    
                        <!--  este label es muy importante, por favor no quitar  -->


                    {{-- Selecciona Evento --}}
                    <div class="formulario rounded col-md-8 d-flex">
                        <select id="evento_id" name="evento_id" class="form-controlstand">
                        <option value="" selected disabled>Selecciona un evento</option>
                        @foreach($event as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->name }}</option>
                        @endforeach
                        </select>
                    </div>

                        {{--  Selecciona Lugar --}}
                    <div class="formulario rounded col-md-8 d-flex">
                        <select id="place_id" name="place_id" class="form-controlstand ">
                        <option value="">Selecciona un lugar</option>
                        </select>
                    </div>

                        {{-- Selecciona Clasificación --}}
                    <div class="formulario rounded col-md-8 d-flex">
                        <select id="classification_id" name="classification_id" class="form-controlstand ">
                            <option value="" selected disabled>Selecciona una clasificación</option>
                            @foreach($classifications as $classification)
                            <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--- URL Logo --}}
                    <div  class="formulario rounded col-md-8 d-flex-block">
                        <label for="logo" class="form-labellogobanner label-register">Logo URL</label>
                        <input type="file" id="logo" class="form-controlstand form-control" name="logo" accept="image/*" required readonly>
                    </div>

                    {{-- URL Banner --}} 
                    <div  class="formulario rounded col-md-8 d-flex-block">
                        <label for="banner" class="form-labellogobanner label-register">Banner URL (tamaño maximo permitido 632x350 pixeles)</label>
                        <input type="file" class="form-controlstand form-control" id="banner" name="banner" accept="image/*" required>
                    </div>

                    {{-- Descripción --}}
                    <div  class="formulario rounded col-md-8 d-flex-block">
                        <input type="text"  name="description" class="form-controlstand form-control" required placeholder="Descripcion"  id="description"  oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div>

                    {{-- Facebook --}}
                    <div class="formulario rounded col-md-8 d-flex-block">
                        <input type="url"  id="input-stand-facebook"name="facebook" class="form-controlstand form-control" required placeholder="Facebook"
                                pattern="https:\/\/(www\.)?facebook\.com\/.*"
                                oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div>
                    
                    {{-- Instagram --}}
                                <div class="formulario rounded col-md-8 d-flex-block">
                <input type="url" id="input-stand-instagram"name="instagram" class="form-controlstand form-control" required placeholder="Instagram"
                        pattern="https:\/\/(www\.)?instagram\.com\/.*"
                        oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                </div>
                    {{-- Tiktok --}}
                    <div class="formulario rounded col-md-8 d-flex-block">
                            <input type="url" id="input-stand-tiktok" name="tiktok" class="form-controlstand form-control" required placeholder="Tiktok"
                                pattern="https:\/\/(www\.)?tiktok\.com\/.*"
                                oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                        </div>
                    {{-- Sitio Web --}}
                    <div class="formulario rounded col-md-8 d-flex-block">
                    <input type="url" id="input-stand-web" name="web" class="form-controlstand form-control" required placeholder="Sitio Web"
                            pattern="https:\/\/.*"
                            oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                </div>

                    {{-- Campos para seleccionar los colores del stand --}}
                        <div  class="formulario rounded col-md-8 d-flex-block">
                        <i class='PaintRollercreate0 bx bxs-paint-roll  bx-border-circle bx-flip-hsser-circle' style="color:#ffffff" id="PaintRollerfondo"></i>
                        <label for="color_contenedor_1" class="label_infovistaprevianombrestandcreate0 d-inline">Color de fondo principal</label>
                        <input type="color" id="color_contenedor_1stand" class="form-controlstand" name="color_contenedor_1" value="#ffffff">
                    </div>  

                    <div  class="formulario rounded col-md-8 d-flex-block">
                        <i class='PaintRollercreate02 bx bx-paint bx-border-circle' style="color:#ffffff" id="PaintRollertitulo"></i>
                        <label for="color_contenedor_2" class="label_infovistaprevianombrestandcreate00 d-inline">Color de letras titulo </label>
                        <input type="color" id="color_contenedor_2stand" class="form-controlstand" name="color_contenedor_2" value="#ffffff">
                    </div>
                    
                    <div  class="formulario rounded col-md-8 d-flex-block">
                        <i class='PaintRollercreate03 bx bxs-palette bx-border-circle' style='color:#ffffff' id="PaintRollerencabezado"></i>
                        <label for="color_contenedor_3" class="label_infovistaprevianombrestandcreate002 d-inline-block ml-2">Color de fondo encabezado</label>
                        <input type="color" id="color_contenedor_3stand" class="form-controlstand" name="color_contenedor_3" value="#ffffff">
                    </div>

                    <div  class="formulario rounded col-md-8 d-flex-block">
                        <i class='Brush bx bx-brush bx-flip-vertical bx-border-circle' style='color:#ffffff' id="Brushcreate"></i>
                        <label for="color_contenedor_4" class="label_infovistaprevianombrestandcreateul d-inline-block">Color de letras pequeñas</label>
                        <input type="color" id="color_contenedor_4stand" class="form-controlstand" name="color_contenedor_4" value="#ffffff">
                    </div>
                    <div class=" formulario rounded form-labelcrearstand label-register col-md-8 d-flex-block">
                        <label for="image1" class="label-register">Imagen 1 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image1" name="images1" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image1', 1)">Eliminar</button>
                    </div>
                    </div>
                    <div class="form-labelcrearstand label-register col-md-8 ">
                        <label for="image2" class="label-register">Imagen 2 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image2" name="images2" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image2', 2)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image3" class="label-register">Imagen 3 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image3" name="images3" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image3', 3)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image4" class="label-register">Imagen 4 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image4" name="images4" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image4', 4)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image5" class="label-register">Imagen 5 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image5" name="images5" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image5', 5)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image6" class="label-register">Imagen 6 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image6" name="images6" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image6', 6)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image7" class="label-register">Imagen 7 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image7" name="images7" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image7', 7)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image8" class="label-register">Imagen 8 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image8" name="images8" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image8', 8)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image9" class="label-register">Imagen 9 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image9" name="images9" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image9', 9)">Eliminar</button>
                    </div>

                    <div class="form-labelcrearstand label-register col-md-8">
                        <label for="image10" class="label-register">Imagen 10 (tamaño maximo permitido 1004x591 pixeles)</label>
                        <input type="file" class="form-controlimgstand image-input" id="image10" name="images10" accept="image/*">
                        <button type="button" class="deletecreate btn delete-image" onclick="deleteImage('image10', 10)">Eliminar</button>
                    </div>
                </div>

            <!-- Contenedor para las imágenes -->
                <div class="stand-visualizacionvistapreviastandcreate0" id="vistapreviaevento">
                    <li class="stands-visualizacionnombrestand align-items-center text-center" id="contenedorpeque">
                        <label class="label_infovistaprevianombrestand" id="nombrestands">Nombre del Stand</label>
                    </li>
                    <label class="label_infovistaprevianombreventocrear" id="informaciondestands">Información del Stand:</label>
                    <div class="carousel-container d-flex flex-column flex-sm-row align-items-center justify-content-center">
                        <button type="button" class="prevcreate mb-2 mb-sm-0 me-sm-2" onclick="prevImage2()">&#10094; Anterior</button>
                        <div id="carouselcrearstand" class="carouselstand mx-3"></div>
                        <button type="button" class="nextCrearStand" onclick="nextImage2()">Siguiente &#10095;</button>
                    </div>
                </div>


                <div class="button-containerCrear">
                    <button type="submit" class="btn btn-submit btnEnviarcrearstandindex">Enviar</button>
                    <a href="{{ route('stand.index') }}" class="btn btnvolverstandindex">Volver</a>
                </div>
                </form>
        </div>
        </div>
    </div>
    </div>
    </div>
</body>
            


<script>
    function deleteImage(imageId, index) {
        const fileInput = document.getElementById(imageId);
        fileInput.value = ''; // Limpiar el campo de archivo
        handleDeleteImage(index); // Eliminar la imagen del carrusel
    }

    function handleDeleteImage(index) {
        const imageToRemove = document.querySelector(`#carouselcrearstand img:nth-child(${index})`);
        if (imageToRemove) {
            imageToRemove.parentNode.removeChild(imageToRemove); // Eliminar la imagen del carrusel
        }
    }
</script>


  
  <!-- <script>
    function deleteImage(imageId, index) {
        const fileInput = document.getElementById(imageId);
        fileInput.value = ''; // Limpiar el campo de archivo
        handleDeleteImage(index); // Eliminar la imagen del carrusel
    }

    function handleDeleteImage(index) {
        const imageToRemove = document.querySelector(`#carouselcrearstand img:nth-child(${index})`);
        if (imageToRemove) {
            imageToRemove.parentNode.removeChild(imageToRemove); // Eliminar la imagen del carrusel
        }
    }
</script> -->
<!-- <script>
    function deleteImage(imageId, index) {
        const fileInput = document.getElementById(imageId);
        fileInput.value = ''; // Limpiar el campo de archivo
        handleDeleteImage(index);
    }
    function handleDeleteImage(index) {
        const fileInput = document.getElementById(`image${index}`);
        fileInput.value = ''; // Limpiar el campo de archivo

        const imageToRemove = document.querySelector(`#carouselcrearstand img:nth-child(${index})`);
        if (imageToRemove) {
            imageToRemove.remove(); // Eliminar la imagen del carrusel
        }
    }
    
        
        // const imageToRemove = document.querySelector(`#carouselcrearstand img:nth-child(${index})`);
        // if (imageToRemove) {
        //     imageToRemove.remove(); // Eliminar la imagen del carrusel
        // }
 
</script> -->
  <!-- <script>
    function deleteImage(imageId) {
        const fileInput = document.getElementById(imageId);
        fileInput.value = ''; // Limpiar el campo de archivo
    }
</script> -->

  <!-- <script>
  // Función para eliminar la imagen del carrusel y ocultar el campo de entrada de imagen
  function deleteImage(imageId, inputId) {
    // Obtener el elemento de imagen y el campo de archivo
    var imageElement = document.getElementById(imageId);
    var inputElement = document.getElementById(inputId);

    // Eliminar la imagen del carrusel
    imageElement.parentNode.removeChild(imageElement);

    // Limpiar el campo de archivo
    inputElement.value = "";
}

</script> -->
  <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const defaultUrls = {
                'input-stand-facebook': 'https://www.facebook.com/',
                'input-stand-instagram': 'https://www.instagram.com/',
                'input-stand-tiktok': 'https://www.tiktok.com/',
                'input-stand-web': 'https://www.example.com/'
            };

            for (const [id, url] of Object.entries(defaultUrls)) {
                const input = document.getElementById(id);
                if (input) {
                    if (!input.value) {
                        input.value = url;
                    }
                    input.addEventListener('input', () => {
                        if (input.value.trim() === '') {
                            input.value = url;
                        }
                    });
                }
            }
        });
    </script>
  <script>
    document.getElementById('banner').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const maxSizeInBytes = 3 * 1024 * 1024; // 3 MB en bytes
        const maxWidth = 632; // Ancho máximo en píxeles
        const maxHeight = 350; // Alto máximo en píxeles

        if (file) {
            if (file.size > maxSizeInBytes) {
                event.target.value = ''; // Limpiar el valor del input si el archivo es demasiado grande
                alert('El tamaño del archivo excede el límite de 3MB.');
                return;
            }

            const img = new Image();
            img.onload = function() {
                if (img.width > maxWidth || img.height > maxHeight) {
                    event.target.value = ''; // Limpiar el valor del input si las dimensiones exceden el límite
                    alert(`Las dimensiones del banner exceden el límite permitido de ${maxWidth}x${maxHeight} píxeles.`);
                    
                }
            };
            img.onerror = function() {
                event.target.value = ''; // Limpiar el valor del input si no es una imagen válida
                alert('El archivo seleccionado no es una imagen válida.');
            };
            img.src = URL.createObjectURL(file);
        }
    });
</script>
<!-- <script>
    const maxFileSize = 3 * 1024 * 1024; // 3MB en bytes
    const maxWidth = 1004; // Ancho máximo en píxeles
    const maxHeight = 591; // Alto máximo en píxeles

    function validateImage(file, callback) {
        if (!file) {
            return callback(false);
        }

        if (file.size > maxFileSize) {
            alert('El tamaño del archivo excede el límite de 3MB.');
            return callback(false);
        }

        const img = new Image();
        img.onload = function() {
            if (img.width > maxWidth || img.height > maxHeight) {
                alert(`Las dimensiones de la imagen exceden el límite permitido de ${maxWidth}x${maxHeight} píxeles.`);
                return callback(false);
            }
            return callback(true);
        };
        img.onerror = function() {
            alert('El archivo seleccionado no es una imagen válida.');
            return callback(false);
        };
        img.src = URL.createObjectURL(file);
    }

    function setupValidation(inputId) {
        const fileInput = document.getElementById(inputId);
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            validateImage(file, function(isValid) {
                if (!isValid) {
                    // Limpiar el campo de archivo si no es válido
                    fileInput.value = '';
                    // Eliminar la imagen del carrusel
                    const imageIndex = inputId.replace('images', '');
                    const imageElement = document.getElementById(`carouselcrearstand`).children[imageIndex - 1];
                    if (imageElement) {
                        imageElement.remove();
                    }
                } else {
                    // Si la imagen es válida, puedes realizar alguna acción adicional aquí, si es necesario
                }
            });
        });
    }

    // Configurar validación para los campos de imagen
    ['image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9', 'image10'].forEach(setupValidation);
</script> -->
<!--     
<script>
    // Función para manejar el cambio en los campos de imagen
   // Función para manejar el cambio en los campos de imagen
function handleImageInputChange(input, index) {
    const fileInput = input;
    const carousel = document.getElementById('carouselcrearstand');

    const file = fileInput.files[0];
    if (file) {
        // Crear un lector de archivos
        const reader = new FileReader();
        reader.onload = function(e) {
            // Crear un elemento de imagen y establecer su fuente como la imagen cargada
            const img = document.createElement('img');
            img.onload = function() {
                // Verificar si la imagen cumple con los requisitos de tamaño
                if (img.width <= maxWidth && img.height <= maxHeight) {
                    // Si cumple, agregar la imagen al carrusel
                    carousel.appendChild(img);
                    // Mostrar la imagen recién agregada
                    showImage(index);
                } else {
                    // Si no cumple, eliminar la imagen del carrusel
                    fileInput.value = ''; // Limpiar el archivo seleccionado
                    if (img.parentNode) {
                        img.parentNode.removeChild(img);
                    }
                    // Opcional: mostrar un mensaje de error al usuario
                    alert('Las dimensiones de la imagen exceden el límite permitido.');
                }
            };
            // Leer el archivo como una URL de datos
            reader.readAsDataURL(file);
        };
        // Leer la imagen para verificar sus dimensiones
        reader.readAsDataURL(file);
    }
}

</script> -->
  <script>
        function showSuccessMessage(message) {
        var successMessageContainer = document.getElementById('success-message-container');
        var successMessage = document.getElementById('success-message');
        successMessage.textContent = message;
       successMessageContainer.style.display = 'block';
                                
      setTimeout(function() {
     successMessageContainer.style.display = 'none';
            }, 3000);
     }

    document.addEventListener('DOMContentLoaded', function () {
   var errorMessageContainer = document.getElementById('error-message-container');
     if (errorMessageContainer) {
                  setTimeout(function() {
                    errorMessageContainer.style.display = 'none';
            }, 3000);
     }
       });
     </script>
  <script>
    // Función para mostrar el mensaje de éxito
    function showSuccessMessage(message) {
        const successMessageContainer = document.getElementById('error-message-container');
        const successMessageElement = document.getElementById('success-message');

        // Mostrar el mensaje de éxito
        successMessageElement.innerText = message;
        successMessageContainer.style.display = 'block';

        // Ocultar el mensaje después de 3 segundos
        setTimeout(function () {
            successMessageContainer.style.display = 'none';
        }, 3000);
    }
</script>
  

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const maxFileSize = 3 * 1024 * 1024; // 3 MB en bytes
  
      const logoInput = document.querySelector('input[name="logo"]');
      const bannerInput = document.querySelector('input[name="banner"]');
  
      logoInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file && file.size > maxFileSize) {
              alert('El tamaño máximo permitido para el logo es de 3 MB.');
              this.value = ''; // Limpiar el archivo seleccionado
          }
      });
  
      bannerInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file && file.size > maxFileSize) {
              alert('El tamaño máximo permitido para el banner es de 3 MB.');
              this.value = ''; // Limpiar el archivo seleccionado
          }
      });
  });
  </script>
     <script>
  
    // Obtener referencia al input de color y a la tarjeta de vista previa
    const colorInput = document.getElementById('color_contenedor_1stand');
    const nombre = document.getElementById('name');
    const descripcion = document.getElementById('description');
    const previewCard = document.getElementById('vistapreviaevento');
    const colorLetras = document.getElementById('color_contenedor_2stand');
    const previewCardletrasNombreStands = document.getElementById('nombrestands');
     const previewCardletrasInformacionstands = document.getElementById('informaciondestands');
    const colorfondopeque = document.getElementById('color_contenedor_3stand');
    const previewCardPeque = document.getElementById('contenedorpeque');       
    const colorLetrasPeque = document.getElementById('color_contenedor_4stand');   
    const prevviewNombre = document.getElementById('nombrestands');   
     const prevviewDescripcion = document.getElementById('informaciondestands');   
    // Escuchar cambios en el input de color
    colorInput.addEventListener('change', function() {
        // Obtener el valor de color seleccionado por el usuario
        const selectedColor = colorInput.value;
        
        // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
        previewCard.style.backgroundColor = selectedColor;
    })
     // Escuchar cambios en el input de color
     colorLetras.addEventListener('change', function() {
        // Obtener el valor de color seleccionado por el usuario
        const selectedColorletras = colorLetras.value;
        
        // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
        previewCardletrasNombreStands.style.color = selectedColorletras;
        
       
    })
    colorLetrasPeque.addEventListener('change', function() {
        // Obtener el valor de color seleccionado por el usuario
        const selectedletraspeque = colorLetrasPeque.value;
        
        // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
         previewCardletrasInformacionstands.style.color = selectedletraspeque;
       
    })
    
      colorfondopeque.addEventListener('change', function() {
        // Obtener el valor de color seleccionado por el usuario
        const selectedColorfondopeque = colorfondopeque.value;
        
        // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
        previewCardPeque.style.backgroundColor = selectedColorfondopeque;
       
  
  
    })
     
    nombre.addEventListener('input', function() {
        // Obtener el valor de color seleccionado por el usuario
        const selectednombre = nombre.value;
        
        // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
        prevviewNombre.innerText   = selectednombre;
    })
    descripcion.addEventListener('input', function() {
        // Obtener el valor de color seleccionado por el usuario
        const selectedInformacion = descripcion.value;
        
        // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
        prevviewDescripcion.innerText   = selectedInformacion;
    })
    ;
</script>
<script>
  // Función para ocultar los campos de imagen que no se necesitan según el número seleccionado en el label
  function ocultarCampos() {
    var cantidadSeleccionada = parseInt(document.getElementById('numero-imagenes-label').textContent);
    var campos = document.querySelectorAll('.form-labelcrearstand label-register'); // Selecciona todos los campos de imagen
  
    // Oculta todos los campos de imagen
    campos.forEach(function(campo, index) {
      campo.style.display = 'none';
    });
  
    // Muestra solo los campos de imagen necesarios según la cantidad seleccionada
    for (var i = 1; i <= cantidadSeleccionada; i++) {
      document.getElementById('image' + i).parentNode.style.display = 'block';
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    // Llama a la función ocultarCampos() al cargar la página para inicializar los campos de imagen
    ocultarCampos();
  
    // Escucha el evento de cambio en el label
    document.getElementById('numero-imagenes-label').addEventListener('DOMSubtreeModified', function() {
      // Llama a la función ocultarCampos() cuando cambie el número en el label
      ocultarCampos();
    });
  });
  </script>

  
  
  
      <script>
  // Función para ocultar los campos de imagen que no se necesitan según el número seleccionado en el label
  function ocultarCampos() {
    var cantidadSeleccionada = parseInt(document.getElementById('numero-imagenes-label').textContent);
    var campos = document.querySelectorAll('.form-labelcrearstand.label-register'); // Selecciona todos los campos de imagen
  
    // Oculta todos los campos de imagen
    campos.forEach(function(campo, index) {
      campo.style.display = 'none';
    });
  
    // Muestra solo los campos de imagen necesarios según la cantidad seleccionada
    for (var i = 1; i <= cantidadSeleccionada; i++) {
      document.getElementById('image' + i).parentNode.style.display = 'block';
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    // Llama a la función ocultarCampos() al cargar la página para inicializar los campos de imagen
    ocultarCampos();
  
    // Escucha el evento de cambio en el label
    document.getElementById('numero-imagenes-label').addEventListener('DOMSubtreeModified', function() {
      // Llama a la función ocultarCampos() cuando cambie el número en el label
      ocultarCampos();
    });
  });
  </script>
<script>
    const maxFileSize = 3 * 1024 * 1024; // 3MB en bytes
const maxWidth = 1004; // Ancho máximo en píxeles
const maxHeight = 591; // Alto máximo en píxeles

let currentIndex = 1;
const intervalTime = 4000;
let interval;

// Función para eliminar la última imagen del carrusel
function handleDeleteLastImage() {
    const images = document.querySelectorAll('#carouselcrearstand img');
    if (images.length > 0) {
        const lastImage = images[images.length - 1];
        lastImage.remove(); // Eliminar la última imagen del carrusel
    }
}

// Función para validar la imagen
function validateImage(file, callback) {
    if (!file) {
        return callback(false);
    }

    if (file.size > maxFileSize) {
        alert('El tamaño del archivo excede el límite de 3MB.');
        handleDeleteLastImage(); // Eliminar la última imagen del carrusel
        return callback(false);
    }

    const img = new Image();
    img.onload = function() {
        if (img.width > maxWidth || img.height > maxHeight) {
            alert(`Las dimensiones de la imagen exceden el límite permitido de ${maxWidth}x${maxHeight} píxeles.`);
            handleDeleteLastImage(); // Eliminar la última imagen del carrusel
            return callback(false);
        }
        return callback(true);
    };
    img.onerror = function() {
        alert('El archivo seleccionado no es una imagen válida.');
        handleDeleteLastImage(); // Eliminar la última imagen del carrusel
        return callback(false);
    };
    img.src = URL.createObjectURL(file);
}

// Función para manejar el cambio en los campos de imagen
function handleImageInputChange(input, index) {
    const fileInput = input;
    const carousel = document.getElementById('carouselcrearstand');

    const file = fileInput.files[0];
    if (file) {
        validateImage(file, function(isValid) {
            if (isValid) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    carousel.appendChild(img);
                    showImage(index);
                };
                reader.readAsDataURL(file);
            } else {
                fileInput.value = ''; // Limpiar el campo de archivo si no es válido
            }
        });
    }
}

// Función para iniciar el carrusel automáticamente
function startCarousel() {
    interval = setInterval(nextImage2, intervalTime);
}

// Función para detener el carrusel
function stopCarousel() {
    clearInterval(interval);
}

// Función para mostrar una imagen específica en el carrusel
function showImage(index) {
    const images = document.querySelectorAll('.carouselstand img');
    images.forEach((img, i) => {
        img.style.display = (i === index) ? 'block' : 'none';
    });
    currentIndex = index;
}

// Función para cambiar a la siguiente imagen en el carrusel
function nextImage2() {
    const images = document.querySelectorAll('.carouselstand img');
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
}

// Función para cambiar a la imagen anterior en el carrusel
function prevImage2() {
    const images = document.querySelectorAll('.carouselstand img');
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
}

// Evento que se dispara cuando la página se ha cargado completamente
document.addEventListener('DOMContentLoaded', () => {
    startCarousel();
});

// Escuchar el evento input de los campos de imagen
['image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8'].forEach((id, index) => {
    document.getElementById(id).addEventListener('input', function() {
        handleImageInputChange(this, index);
    });
});

// Función para manejar la eliminación manual de imágenes
function handleDeleteImage(index) {
    const fileInput = document.getElementById(`image${index}`);
    fileInput.value = ''; // Limpiar el campo de archivo

    const imageToRemove = document.querySelector(`#carouselcrearstand img:nth-child(${index})`);
    if (imageToRemove) {
        imageToRemove.remove(); // Eliminar la imagen del carrusel
    }
}

// Añadir eventos a los botones de eliminación de imagen
document.querySelectorAll('.delete-image').forEach(button => {
    button.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        handleDeleteImage(index);
    });
});
</script>
<!-- <script>
    // Variable para mantener el índice de la imagen actual
    let currentIndex = 1;
    // Intervalo de tiempo en milisegundos (2 segundos en este ejemplo)
    const intervalTime = 4000;
    // Variable para el intervalo del carrusel
    let interval;
    function handleImageInputChange(input, index) {
        const fileInput = input;
        const carousel = document.getElementById('carouselcrearstand');

        const file = fileInput.files[0];
        if (file) {
            // Crear un lector de archivos
            const reader = new FileReader();
            reader.onload = function(e) {
                // Crear un elemento de imagen y establecer su fuente como la imagen cargada
                const img = document.createElement('img');
                img.src = e.target.result;
                // Agregar la imagen al carrusel en la posición especificada
                carousel.appendChild(img);
                // Mostrar la imagen recién agregada
                showImage(index);
            };
            // Leer el archivo como una URL de datos
            reader.readAsDataURL(file);
        } else {
            // Si no se seleccionó ningún archivo, eliminar la imagen correspondiente del carrusel
            const imageToRemove = document.querySelector(`#carouselcrearstand img:nth-child(${index})`);
            if (imageToRemove) {
                carousel.removeChild(imageToRemove);
            }
        }
    }

    // Función para iniciar el carrusel automáticamente
    function startCarousel() {
        interval = setInterval(nextImage2, intervalTime);
    }

    // Función para detener el carrusel
    function stopCarousel() {
        clearInterval(interval);
    }

    // Función para mostrar una imagen específica en el carrusel
    function showImage(index) {
        const images = document.querySelectorAll('.carousel img');
        // Iterar sobre todas las imágenes
        images.forEach((img, i) => {
            // Mostrar la imagen actual y la nueva imagen seleccionada
            if (i === index) {
                img.style.display = 'block';
            } else {
                // Ocultar las demás imágenes
                img.style.display = 'none';
            }
        });
        // Actualizar el índice de la imagen actual
        currentIndex = index;
    }

    // Función para cambiar a la siguiente imagen en el carrusel
    function nextImage2() {
        const images = document.querySelectorAll('.carousel img');
        // Actualizar el índice de la imagen actual
        currentIndex = (currentIndex + 1) % images.length;
        // Mostrar la imagen actualizada
        showImage(currentIndex);
    }

    // Función para cambiar a la imagen anterior en el carrusel
    function prevImage2() {
        const images = document.querySelectorAll('.carousel img');
        // Actualizar el índice de la imagen actual
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        // Mostrar la imagen actualizada
        showImage(currentIndex);
    }

    // Evento que se dispara cuando la página se ha cargado completamente
    document.addEventListener('DOMContentLoaded', () => {
        // Iniciar el carrusel automáticamente cuando la página se carga
        startCarousel();
    });

    // Escuchar el evento input del campo image1
    document.getElementById('image1').addEventListener('input', function() {
        handleImageInputChange(this, 1);
    });

    // Escuchar el evento input del campo image2
    document.getElementById('image2').addEventListener('input', function() {
        handleImageInputChange(this, 2);
    });

    // Escuchar el evento input del campo image3
    document.getElementById('image3').addEventListener('input', function() {
        handleImageInputChange(this, 3);
    });

    // Escuchar el evento input del campo image4
    document.getElementById('image4').addEventListener('input', function() {
        handleImageInputChange(this, 4);
    });

    // Escuchar el evento input del campo image5
    document.getElementById('image5').addEventListener('input', function() {
        handleImageInputChange(this, 5);
    });

    // Escuchar el evento input del campo image6
    document.getElementById('image6').addEventListener('input', function() {
        handleImageInputChange(this, 6);
    });

    // Escuchar el evento input del campo image7
    document.getElementById('image7').addEventListener('input', function() {
        handleImageInputChange(this, 7);
    });

    // Escuchar el evento input del campo image8
    document.getElementById('image8').addEventListener('input', function() {
        handleImageInputChange(this, 8);
    });
    document.getElementById('image9').addEventListener('input', function() {
        handleImageInputChange(this, 8);
    });
    document.getElementById('image10').addEventListener('input', function() {
        handleImageInputChange(this, 8);
    });

    // Función para manejar el cambio en los campos de imagen
    function handleImageInputChange(input, index) {
        const fileInput = input;
        const carousel = document.getElementById('carouselcrearstand');

        const file = fileInput.files[0];
        if (file) {
            // Crear un lector de archivos
            const reader = new FileReader();
            reader.onload = function(e) {
                // Crear un elemento de imagen y establecer su fuente como la imagen cargada
                const img = document.createElement('img');
                img.src = e.target.result;
                // Agregar la imagen al carrusel en la posición especificada
                carousel.appendChild(img);
                // Mostrar la imagen recién agregada
                showImage(index);
            };
            // Leer el archivo como una URL de datos
            reader.readAsDataURL(file);
        }
    }
</script> -->


    <script>
        function validateImageSize() {
            const maxFileSize = 3 * 1024 * 1024; // 3 MB en bytes
            const imageInputs = document.querySelectorAll('.image-input');

            imageInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    const files = this.files;
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxFileSize) {
                            alert('El tamaño máximo permitido para cada imagen es de 3 MB.');
                            this.value = ''; // Borrar el archivo seleccionado
                            return;
                        }
                    }
                });
            });
        }

        window.addEventListener('DOMContentLoaded', function() {
            validateImageSize();
        });
    </script>


     
    <script>
      
      //crea los inputs
       // Variable para contar el número de imágenes agregadas
      let imageCounter = 1;
      
      // Contenedor donde se agregarán los campos de carga de imágenes
      const container = document.getElementById("image-upload-container");
      
      // Etiqueta que muestra el número máximo de imágenes permitidas
      const numeroImagenesLabel = document.getElementById("numero-imagenes-label");
      
      // Menú desplegable de eventos
      const eventSelect = document.getElementById("evento_id");
      
      // Función para agregar dinámicamente los campos de carga de imágenes
      function addImageInputs() {
          // Vaciar el contenedor para eliminar los campos de carga de imágenes existentes
          container.innerHTML = '';
      
          // Obtener el número de imágenes permitidas del contenido del label
          let maxImages = parseInt(numeroImagenesLabel.textContent.trim());
      
          // Agregar los nuevos campos de carga de imágenes según el número de imágenes permitidas
          for (let i = 0; i < maxImages; i++) {
              // Crear un nuevo contenedor para cada imagen
              const newImageContainer = document.createElement("div");
              newImageContainer.classList.add("input-group", "mb-3");
      
              // Crear una etiqueta para identificar el campo de carga de imagen
              const label = document.createElement("label");
              label.setAttribute("for", image${imageCounter});
              label.classList.add("label-register");
              label.textContent = Imagen ${imageCounter}:;
              newImageContainer.appendChild(label);
      
              // Crear el campo de carga de imagen
              const input = document.createElement("input");
              input.setAttribute("type", "file");
              input.classList.add("form-control", "input-register", "image-input");
              input.setAttribute("id", image${imageCounter});
              input.setAttribute("name", images${imageCounter});
              input.setAttribute("accept", "image/*");
              input.setAttribute("required", true);
              newImageContainer.appendChild(input);
      
              // Crear el botón para eliminar la imagen
              const deleteButton = document.createElement("button");
              deleteButton.setAttribute("type", "button");
              deleteButton.classList.add("btn", "btn-danger", "delete-image");
              deleteButton.textContent = "Eliminar";
              deleteButton.addEventListener("click", function () {
                  // Eliminar el contenedor de la imagen cuando se hace clic en el botón Eliminar
                  container.removeChild(newImageContainer);
                  // Decrementar el contador de imágenes
                  imageCounter--;
              });
              newImageContainer.appendChild(deleteButton);
      
              // Agregar el contenedor de la imagen al contenedor principal
              container.appendChild(newImageContainer);
      
              // Incrementar el contador de imágenes
              imageCounter++;
          }
      }
      
      // Escuchar el evento de cambio en el menú desplegable de eventos
      eventSelect.addEventListener('change', async (e) => {
          try {
              const eventId = e.target.value;
              console.log(Evento seleccionado: ${eventId});
      
              // Realizar una solicitud para obtener los datos del evento seleccionado
              const response = await fetch(/evento/${eventId});
              if (!response.ok) {
                  throw new Error('Error al obtener los datos del evento');
              }
      
              const eventData = await response.json();
              console.log('Datos del evento:', eventData);
      
              // Verificar si se recuperaron correctamente los datos del evento
              if (!eventData || !eventData.numero_imagenes) {
                  throw new Error('Datos del evento incompletos');
              }
      
              // Actualizar el número de imágenes permitidas en el label
              numeroImagenesLabel.textContent = ${eventData.numero_imagenes};
      
              // Agregar dinámicamente los campos de carga de imágenes
              addImageInputs();
          } catch (error) {
              console.error('Error al seleccionar el evento:', error);
          }
      });
      
      // Llamar a la función addImageInputs() al cargar la página para inicializar los campos de carga de imágenes
      addImageInputs();   
          
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
  
          // Mostrar el número de imágenes oculto en el div
          numeroImagenesMostrado.textContent = `${data.numero_imagenes}`;
          document.getElementById('numero_imagenes_container').style.display = 'block'; // Mostrar el contenedor
      });
  </script>
      
      
  
      <script>
      // Verificar el tamaño del archivo al seleccionarlo
      document.getElementById('logo').addEventListener('change', function(event) {
          const file = event.target.files[0];
          const maxSizeInBytes = 3 * 1024 * 1024; // 3 MB en bytes
  
          if (file && file.size > maxSizeInBytes) {
              event.target.value = ''; // Limpiar el valor del input si el archivo es demasiado grande
              alert('El tamaño del archivo excede el límite de 3MB.');
          }
      });
  
      // Verificar el tamaño del archivo al seleccionarlo
      document.getElementById('banner').addEventListener('change', function(event) {
          const file = event.target.files[0];
          const maxSizeInBytes = 3 * 1024 * 1024; // 3 MB en bytes
  
          if (file && file.size > maxSizeInBytes) {
              event.target.value = ''; // Limpiar el valor del input si el archivo es demasiado grande
              alert('El tamaño del archivo excede el límite de 3MB.');
          }
      });
  </script>
      <script>
      var colorPicker = document.getElementById("colorPicker");
  
      colorPicker.addEventListener("input", function() {
          var color = colorPicker.value;
          document.getElementById('color_contenedor_1').style.borderColor = color;
          document.getElementById('color_contenedor_1').style.color = color;
      }, false);
  </script>
      
  
  @endsection
  