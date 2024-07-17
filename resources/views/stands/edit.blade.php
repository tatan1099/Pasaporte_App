@extends('layouts.app')

@section('content')
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
                    <form class="stand-form" action="{{ route('stand.update', ['stand' => $stand->id] ) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="inputscrearstand">
                            <!-- Nombre -->
                            <div class="formulario rounded col-md-8">
                                <input type="text" name="name" class="form-controlstand form-control" required placeholder="Nombre Stand" value="{{ $stand->name }}" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                            </div>

                            <!-- Evento -->
                            <div class="formulario rounded col-md-8 d-flex">
                                <select id="classification_id" name="classification_id[]" class="form-controlstand form-control">
                                    <option value="" selected disabled>Selecciona una clasificación</option>
                                    @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}" {{ in_array($classification->id, $existentClassifications) ? 'selected' : '' }}>{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Logo URL -->
                            <div class="formulario rounded col-md-8 d-flex-block" style="display: flex; flex-direction: column;">
                                <label for="logo" class="form-labellogobanner label-register">Logo URL</label>
                                <div class="input-group mb-3-editstan" style="display: flex; align-items: center; gap: 7px;">
                                    <input type="text" class="form-controlstand posicionlabelstandlogo form-control" name="logo" value="{{$stand->logo}}" readonly style="border-radius: 50px;">
                                    <button type="button" class="btn" id="newlogooo" onclick="document.getElementById('new_logo').click()">Cargar Nuevo Logo</button>
                                    <input type="file" id="new_logo" name="new_logo" style="display: none" class="form-controlstand form-control">
                                </div>
                            </div>



                            <!-- Banner URL -->
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <label for="banner" class="form-labellogobanner form-labebanner label-register">Banner URL</label>
                                <div class="input-group mb-3-editstan" style="display: flex; align-items: center; gap: 10px;">
                                    <input type="text" class="form-controlstand posicionlabelstandbanner form-control" id="banner" name="banner" value="{{$stand->banner}}" readonly style="border-radius: 50px;">
                                    <div class="input-group-append">
                                    <button type="button" class="btn" id="newlogooobanner" onclick="document.getElementById('new_banner').click()">Cargar Nuevo Banner</button>
                                    </div>
                                </div>
                                <input type="file" id="new_banner" name="new_banner" style="display: none">
                            </div>

                            <!-- Descripción -->
                            <div class="formulario rounded col-md-8">
                                <input type="hidden" name="evento_id" value="{{ $stand->event->id }}">
                                <input type="text" class="form-controlstand form-control" name="description" value="{{ $stand->description }}" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                            </div>

                            <!-- Redes Sociales -->
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <span class="input-group-texteditt d-inline">Facebook</span>
                                <input type="text" class="form-controlstand form-control" name="facebook" value="{{$stand->facebook}}" onblur="validateURL(this, 'facebook')">
                            </div>
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <span class="input-group-textedittt d-inline">Instagram</span>
                                <input type="text" class="form-controlstand form-control" name="instagram" value="{{$stand->instagram}}" onblur="validateURL(this, 'instagram')">
                            </div>
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <span class="input-group-texttiktok d-inline">TikTok</span>
                                <input type="text" class="form-controlstand form-control" name="tiktok" value="{{$stand->tiktok}}" onblur="validateURL(this, 'tiktok')">
                            </div>
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <span class="input-group-textweb d-inline">Sitio web</span>
                                <input type="text" class="form-controlstand form-control" name="web" value="{{$stand->web}}" onblur="validateURL(this, 'web')">
                            </div>

                            <!-- Selección de colores -->
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <i class='Paint bx bx-paint bx-rotate-270 bx-border-circle' style="color:#ffffff" id="Paint"></i>
                                <label for="color_contenedor_1" class="form-label00033 ">Color de fondo principal</label>
                                <input type="color" id="color_contenedor_1" class="form-controlstand posicioncontenedor1" name="color_contenedor_1" value="{{ $stand->color_contenedor_1}}">
                            </div>
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <i class='Palette bx bxs-palette bx-border-circle' style="color:#ffffff" id="Palette"></i>
                                <label for="color_contenedor_2" class="form-label003 d-inline">Color de letras titulo</label>
                                <input type="color" id="color_contenedor_2" class="form-controlstand posicioncontenedor2" name="color_contenedor_2" value="{{ $stand->color_contenedor_2}}">
                            </div>
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <i class='PaintRoller bx bxs-paint-roll bx-flip-horizontal bx-border-circle' style="color:#ffffff" id="PaintRoller02"></i>
                                <label for="color_contenedor_3" class="form-label0033 d-inline">Color de fondo encabezado</label>
                                <input type="color" id="color_contenedor_3" class="form-controlstand posicioncontenedor3" name="color_contenedor_3" value="{{ $stand->color_contenedor_3 }}">
                            </div>
                            <div class="formulario rounded col-md-8 d-flex-block">
                                <i class='Brush bx bx-brush bx-flip-vertical bx-border-circle' style="color:#ffffff" id="Brush02"></i>
                                <label for="color_contenedor_4" class="form-label01033 d-inline">Color de letras pequeñas</label>
                                <input type="color" id="color_contenedor_4" class="form-controlstand posicioncontenedor4" name="color_contenedor_4" value="{{ $stand->color_contenedor_4 }}">
                            </div>

                            <!-- Campos para las imágenes existentes -->
                            @for($i = 1; $i <= 10; $i++)
                                @php
                                $imageField = 'images' . $i;
                                @endphp
                                @if($stand->$imageField)
                                <div class="formulario rounded col-md-8 d-flex-block" style="display: flex; flex-direction: column;">
                                    <span class="input-group-textimages d-inline">Imagen {{ $i }} URL</span>
                                    <div class="input-group mb-3-editstan" style="display: flex; align-items: center; gap: 10px;">
                                        <input type="text" class="form-control posicionimageneseditstd" name="{{ $imageField }}" value="{{ $stand->$imageField }}" readonly style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                        <button type="button" class="btn nuevaimagen borderbtnimageneditstand" onclick="document.getElementById('new_{{ $imageField }}').click()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Cargar Nueva Imagen {{ $i }}</button>
                                    </div>
                                    <input type="file" id="new_{{ $imageField }}" name="new_{{ $imageField }}" class="form-controlstand" style="display: none;">
                                </div>

                                @endif
                            @endfor
                        </div>

                         <!-- Contenedor para las imágenes -->
                        <div class="stand-visualizacionvistapreviastand" style="background-color: {{ $stand->color_contenedor_1}}" id="vistapreviaevento">
                            <li class="stands-visualizacionnombrestand align-items-center text-center" id="contenedorpeque" style="background-color: {{ $stand->color_contenedor_3}};">
                                <label class="label_infovistaprevianombrestand" id="nombrestands" style="color: {{ $stand->color_contenedor_2}}">{{ $stand->name }}</label>
                            </li>
                            <label class="label_infovistaprevianombrevento" style="color: {{ $stand->color_contenedor_4 }}" id="informaciondestands">{{ $stand->description }}</label>
                            <div class="carousel-container d-flex flex-column flex-sm-row align-items-center justify-content-center">
                                <button type="button" class="prevedit mb-2 mb-sm-0 me-sm-2" onclick="prevImage2()">&#10094; Anterior</button>
                                <div id="carousel" class="carouselEditstand mx-3 mb-3 mb-sm-0">
                                    @for ($i = 1; $i <= 8; $i++)
                                        @if ($stand->{'images'.$i})
                                            <img src="{{ asset($stand->{'images'.$i}) }}" class="carousel-image">
                                        @endif
                                    @endfor
                                </div>
                                <button type="button" class="nextGenerareventoSTAND" onclick="nextImage2()">Siguiente &#10095;</button>
                            </div>
                        </div>


                        <!-- Botones de acción -->
                        <div class="container-botones">
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center pb-3">
                                <!-- <button type="button" class="btn delete2 mb-2 mb-md-0 me-md-2" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-stand-id="{{ $stand->id }}">Eliminar Stand</button> -->
                                <button type="submit" class="btn edit editbtnstand  mb-2 mb-md-0 me-md-2">Actualizar Stand</button>
                                <a class="btn back" href="{{ route('stand.index', ['eventId' => $stand->event->id]) }}">Volver</a>
                            </div>
                        </div>
                         <!-- Modal de confirmación de eliminación
                         <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmar eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que quieres eliminar este stand?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form id="delete-form" method="POST" action="{{ route('stand.destroy', ['stand' => $stand->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </form>

                    <!-- Script de éxito -->
                    <script>
                        function showSuccessMessage(message) {
                            const successMessageContainer = document.getElementById('success-message-container');
                            const successMessageElement = document.getElementById('success-message');
                            successMessageElement.innerText = message;
                            successMessageContainer.style.display = 'block';

                            setTimeout(function () {
                                successMessageContainer.style.display = 'none';
                            }, 5000);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>


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
<script>
    function validateURL(input, platform) {
        // Expresión regular para validar URL
        const urlPattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?\/?$/;

        // Obtener el valor del campo de entrada
        const url = input.value.trim();

        // Verificar si la URL cumple con el patrón esperado
        if (!urlPattern.test(url)) {
            alert(`La URL de ${platform} no es válida.`);
            input.value = ''; // Limpiar el campo
            input.focus(); // Devolver el foco al campo
        }
    }
</script>
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
    document.addEventListener('DOMContentLoaded', () => {
        startCarousel();
        initializeImageInputs();
    });

    const maxFileSize = 3 * 1024 * 1024; // 3MB en bytes
    const maxWidth = 1004; // Ancho máximo en píxeles
    const maxHeight = 591; // Alto máximo en píxeles
    let currentIndex = 0;
    const intervalTime = 4000;
    let interval;
    let imageUrls = []; // Array para almacenar las URL de las imágenes seleccionadas

    function startCarousel() {
        interval = setInterval(nextImage2, intervalTime);
    }

    function stopCarousel() {
        clearInterval(interval);
    }

    function showImage(index) {
        const images = document.querySelectorAll('.carouselEditstand-image');
        images.forEach((img, i) => {
            img.style.display = (i === index) ? 'block' : 'none';
        });
        currentIndex = index;
    }

    function nextImage2() {
        const images = document.querySelectorAll('.carouselEditstand-image');
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function prevImage2() {
        const images = document.querySelectorAll('.carouselEditstand-image');
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }

    function initializeImageInputs() {
        ['new_images1', 'new_images2', 'new_images3', 'new_images4', 'new_images5', 'new_images6', 'new_images7', 'new_images8'].forEach((id, index) => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('change', function() {
                    handleImageInputChange(this, index + 1); // El índice comienza desde 1 en este caso
                });
            }
        });
    }

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

    function handleImageInputChange(input, index) {
        const file = input.files[0];
        if (file) {
            validateImage(file, function(isValid) {
                if (isValid) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageUrl = e.target.result;
                        imageUrls[index - 1] = imageUrl; // Guardar la URL de la imagen en el array

                        // Actualizar solo la imagen correspondiente en el carrusel
                        const imgToUpdate = document.getElementById(`carousel`).querySelector(`img:nth-child(${index})`);
                        if (imgToUpdate) {
                            imgToUpdate.src = imageUrl;
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    input.value = ''; // Limpiar el campo de archivo si no es válido
                }
            });
        }
    }
</script>

    <!-- <script>
    let currentImageIndex = 0;
    const carouselImages = document.querySelectorAll('.carousel-image');

    // Ocultar todas las imágenes excepto la primera
    for (let i = 1; i < carouselImages.length; i++) {
        carouselImages[i].style.display = 'none';
    }

    function prevImage2() {
        carouselImages[currentImageIndex].style.display = 'none';
        currentImageIndex = (currentImageIndex - 1 + carouselImages.length) % carouselImages.length;
        carouselImages[currentImageIndex].style.display = 'block';
    }

    function nextImage2() {
        carouselImages[currentImageIndex].style.display = 'none';
        currentImageIndex = (currentImageIndex + 1) % carouselImages.length;
        carouselImages[currentImageIndex].style.display = 'block';
    }
</script> -->
    <script>

  // Obtener referencia al input de color y a la tarjeta de vista previa
  const colorInput = document.getElementById('color_contenedor_1');
  const nombre = document.getElementById('name');
  const descripcion = document.getElementById('description');
  const previewCard = document.getElementById('vistapreviaevento');
  const colorLetras = document.getElementById('color_contenedor_2');
  const previewCardletrasNombreStands = document.getElementById('nombrestands');
   const previewCardletrasInformacionstands = document.getElementById('informaciondestands');
  const colorfondopeque = document.getElementById('color_contenedor_3');
  const previewCardPeque = document.getElementById('contenedorpeque');       
  const colorLetrasPeque = document.getElementById('color_contenedor_4');   
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
      const selectedColorletraspe = colorLetrasPeque.value;
      
      // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
       previewCardletrasInformacionstands.style.color = selectedColorletraspe;
     
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

@endsection