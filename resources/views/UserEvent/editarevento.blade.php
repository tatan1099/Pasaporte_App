@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="containerediatarevento">
        <div class="card-empresa">
            <div class="titleHeaderEditEvent">
                <img class="logo-evaluationeditarevento d-block" src="{{ asset('images/Crearevento.png') }}" alt="">
                <h2 class="tittleEvent_2editareven d-inline-block"> Evento</h2>
            </div>
            <br>
            <br>
            <br>
            <div class="card-body container-bodyEditEvent">
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
                <form action="{{ route('UserEvent.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Campo para el nombre del evento -->
                    <div class="mb-3create rounded">
                        <label for="name" class="titlesEditEvent form-label">Nombre del Evento</label>
                        <input type="text" id="name" name="name" class="form-controleditevent" value="{{ $evento->name }}" required oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div><br>

                <div class="mb-3create rounded">
                <label class="form-label titlesEditEvent">Logo URL</label>
                <input type="text" class="form-controleditevent" name="logo" value="{{$evento->logo}}" readonly>
                <br>
                <button type="button" class="btnNewLogoEditEvent btn " onclick="document.getElementById('new_logo').click()">Cargar Nuevo Logo</button>
                <input type="file" id="new_logo" name="new_logo" style="display: none">
            </div><br>

            <div class="mb-3create rounded">
                <label class="form-label titlesEditEvent">Banner URL</label>
                <input type="text" class="form-controleditevent" name="banner" value="{{$evento->banner}}" readonly>
                <br>

                <button type="button" class="btnNewBannerEditEvent btn " onclick="document.getElementById('new_banner').click()">Cargar Nuevo Banner</button>
                <input type="file" id="new_banner" name="new_banner" style="display: none">
            </div><br>

                    <!-- Campo para la descripción -->
                    <div class="mb-3create rounded">
                        <label for="description" class="form-label titlesEditEvent">Descripción</label>
                        <textarea id="description" name="description" class="form-controleditevent" style="height: 100px" required oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">{{ $evento->description }}</textarea>
                    </div><br>

                    <!-- Campos para las redes sociales -->
                    <div class="mb-3create rounded">
                        <label for="facebook" class="form-label titlesEditEvent">Facebook</label>
                        <input type="url" id="facebook" name="facebook" class="form-controleditevent" value="{{ $evento->facebook }}"
                            placeholder="https://www.facebook.com/usuario" pattern="https:\/\/(www\.)?facebook\.com\/.*"
                            oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div><br>

                    <div class="mb-3create rounded">
                        <label for="instagram" class="form-label titlesEditEvent">Instagram</label>
                        <input type="url" id="instagram" name="instagram" class="form-controleditevent" value="{{ $evento->instagram }}"
                            placeholder="https://www.instagram.com/usuario" pattern="https:\/\/(www\.)?instagram\.com\/.*"
                            oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div><br>

                    <div class="mb-3create rounded">
                        <label for="tiktok" class="form-label titlesEditEvent">TikTok</label>
                        <input type="url" id="tiktok" name="tiktok" class="form-controleditevent" value="{{ $evento->tiktok }}"
                            placeholder="https://www.tiktok.com/@usuario" pattern="https:\/\/(www\.)?tiktok\.com\/.*"
                            oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div><br>

                    <div class="mb-3create rounded">
                        <label for="web" class="form-label titlesEditEvent">Página Web</label>
                        <input type="url" id="web" name="web" class="form-controleditevent" value="{{ $evento->web }}"
                            placeholder="https://www.paginaweb.com" pattern="https:\/\/.*"
                            oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div><br>

                    <!-- Campos para las fechas -->
                    <div class="mb-3create rounded">
                        <label for="fechainicio" class="form-label titlesEditEvent">Fecha de Inicio</label>
                        <input type="date" id="fechainicio" name="fechainicio" class="form-controleditevent" value="{{ $evento->start_date }}">
                    </div><br>

                    <div class="mb-3create rounded">
                        <label for="fechaFin" class="form-label titlesEditEvent">Fecha Fin</label>
                        <input type="date" id="fechaFin" name="fechaFin" class="form-controleditevent" value="{{ $evento->end_date }}">
                    </div><br>
                    <i class='PaintRollerfondoevenedit bx bxs-paint-roll bx-flip-horizontal bx-border-circle' style="color:#ffffff" ></i>
                    <div class="mb-3create rounded">  
                    <label for="color_contenedor_1" class="label_fondograndeeveedit">Color de fondo principal</label>
                    <input type="color" id="input-eventofondogrande" class="form-espacioseventosedite" name="color_contenedor_1" value="{{ $evento->color_contenedor_1 }}">
                    </div>

                    
                    <i class='PaintRollercreateeventoedit bx bx-paint bx-border-circle' style="color:#ffffff" ></i>
                    <div class="mb-3create rounded">
                    <label for="color_contenedor_2" class="label_letrastituloeventoedit">Color de letras titulo </label>
                    <input type="color" id="input-eventoletrastit" class="form-espacioseventosedite" name="color_contenedor_2" value="{{ $evento->color_contenedor_2 }}">
                    </div>

                    <!-- Campos para los colores -->
                    <i class='PaintRoller_1editevent bx bxs-paint-roll bx-flip-horizontal bx-border-circle' style="color:#ffffff" id="PaintRoller_1"></i>
                    <div class="mb-3create rounded">
                        <label for="color_contenedor_3" class="form-label titlesEditEvent">Color fondo encabezado</label>
                        <input type="color" id="color_contenedor_3evento" name="color_contenedor_3" class="form-controlediteventcolor" value="{{ $evento->color_contenedor_3 }}">
                    </div><br>
                    <i class='Paint_1editevent bx bx-paint bx-rotate-270 bx-border-circle' style="color:#ffffff" id="Paint_1"></i>
                    <div class="mb-3create rounded">
                        <label for="color_contenedor_4" class="form-label titlesEditEvent">Color de letras pequeñas</label>
                        <input type="color" id="color_contenedor_4evento" name="color_contenedor_4" class="form-controlediteventcolor" value="{{ $evento->color_contenedor_4 }}">
                    <br><br>
                    <!-- Campo para seleccionar la cantidad de imágenes -->
                    <div class="formEvent_1 col-md-8 d-flex-block">
                        <label for="numero_imagenes" class="label_color form-labelseleccciónimageneseventoe">Selecciona la cantidad de imágenes para los stands</label>
                        <select name="numero_imagenes" id="numero_imagenes" class="form-controleditevent   form-espacioseventoseditarev" value ="{{$evento->numero_imagenes}}">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select><br>
                    </div>
                    
                    @for($i = 1; $i <= 8; $i++)
                    @php
                        $imagesField = 'images' . $i;
                    @endphp
                    @if($evento->$imagesField)
                        <div class="formulario rounded">
                            <label for="numero_imagenes" class=" form-labelseleccciónimageneseventoediatr">Selecciona las imagenes para el evento </label>
                            <div class="mb-3-editstanevnt input-group">
                                
                                <input type="text" class="form-controleditevento" id="imageUrl{{ $i }}" name="{{ $imagesField }}" value="{{ $evento->$imagesField }}" readonly>
                                <button type="button" onclick="document.getElementById('new_{{ $imagesField }}').click()" id="btnplfotoedit"> Cargar </button>
                                <input type="file" id="new_{{ $imagesField }}" name="new_{{ $imagesField }}" style="display: none" onchange="handleImageInputChange(this, {{ $i }})">
                                <button type="button" class="delete-image" id="btnpelimnuevai" data-index="{{ $i }}">Eliminar</button>
                            </div>
                        </div>
                    @endif
                @endfor

                <!-- Contenedor para las imágenes -->
                <div class="stand-visualizacionvistapreviaevento1" id="vistapreviaevento" style="background-color: {{ $evento->color_contenedor_1 }}">
                    <li class="stands-visualizacionnombreevento text-center" id="contenedorpe" style="background-color: {{ $evento->color_contenedor_3 }}">
                        <label class="label_colorvistaprevianombrevento" id="nombreevento" style="color: {{ $evento->color_contenedor_2 }};">{{ $evento->name }}</label>
                    </li>
                    <label class="label_infovistaprevianombrevento poscionlabelinfoevento text-center" id="informacióndeleve" style="color: {{ $evento->color_contenedor_4 }}">{{ $evento->description }}</label>
                    <div class="carousel-containerGenerare d-flex flex-column flex-sm-row align-items-center justify-content-center">
                        <button type="button" class="preveditevent mb-2 mb-sm-0 me-sm-2" onclick="prevImage2()">&#10094;Anterior</button>
                        <div id="carousel-innerreditar" class="carouselediteven mx-3 mb-3 mb-sm-0">
                            @for ($i = 1; $i <= 8; $i++)
                                @if ($evento->{'images'.$i})
                                    <img src="{{ asset($evento->{'images'.$i}) }}" class="carousel-image">
                                @endif
                            @endfor
                        </div>
                        <button type="button" class="nextGenerareventoEVENTO" onclick="nextImage2()">Siguiente &#10095;</button>
                    </div>
                </div><br>



                <!-- Botones para enviar y volver -->
                <div class="row text-center">
                    <div class="col">
                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center pb-3">
                    <button type="submit" class="btn GuardarEditarevento ">Guardar Cambios</button><br>
                        <a href="{{ route('UserEvent.listaeventos') }}" class="btn VolverEditarevento">Volver</a>
                    </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>
</body>
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
        const images = document.querySelectorAll('.carouselediteven img');
        images.forEach((img, i) => {
            img.style.display = (i === index) ? 'block' : 'none';
        });
        currentIndex = index;
    }

    function nextImage2() {
        const images = document.querySelectorAll('.carouselediteven img');
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function prevImage2() {
        const images = document.querySelectorAll('.carouselediteven img');
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
                        const carousel = document.getElementById('carousel-innerreditar');
                        const imgToUpdate = carousel.querySelector(`img:nth-child(${index})`);
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
        const images = document.querySelectorAll('.carousel img');
        images.forEach((img, i) => {
            img.style.display = (i === index) ? 'block' : 'none';
        });
        currentIndex = index;
    }

    function nextImage2() {
        const images = document.querySelectorAll('.carousel img');
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function prevImage2() {
        const images = document.querySelectorAll('.carousel img');
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
                        const carousel = document.getElementById('carousel-innerreditar');
                        const imgToUpdate = carousel.querySelector(`img:nth-child(${index})`);
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

// Obtener referencia al input de color y a la tarjeta de vista previa
const colorfondogrande = document.getElementById('input-eventofondogrande');
const nombre = document.getElementById('name');
const descripcion = document.getElementById('description');
const previewCard = document.getElementById('vistapreviaevento');
const colorLetrastitulo = document.getElementById('input-eventoletrastit');
const fondoencabezado = document.getElementById('color_contenedor_3evento');
const aplicacionpeque = document.getElementById('contenedorpe');
const colorLetraspequeño = document.getElementById('color_contenedor_4evento');
const previewCardletrastitulo = document.getElementById('nombreevento');
const previewCardletrasdes = document.getElementById('informacióndeleve');
const previewCardletrasredes = document.getElementById('redes');
const previewCardnombre = document.getElementById('nombreevento');
const previewCardInform = document.getElementById('informacióndeleve');

// Escuchar cambios en el input de color
colorfondogrande.addEventListener('change', function() {
    // Obtener el valor de color seleccionado por el usuario
    const selectedColor = colorfondogrande.value;
    
    // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
    previewCard.style.backgroundColor = selectedColor;
})
fondoencabezado.addEventListener('change', function() {
    // Obtener el valor de color seleccionado por el usuario
    const selectedColorfondoencabezado = fondoencabezado.value;
    
    // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
    aplicacionpeque.style.backgroundColor = selectedColorfondoencabezado;
})
 // Escuchar cambios en el input de color
 colorLetrastitulo.addEventListener('change', function() {
    // Obtener el valor de color seleccionado por el usuario
    const selectedColorletrastitulo = colorLetrastitulo.value;
    
    // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
    previewCardletrastitulo.style.color = selectedColorletrastitulo;
})
colorLetraspequeño.addEventListener('change', function() {
    // Obtener el valor de color seleccionado por el usuario
    const selectedColorletraspequño = colorLetraspequeño.value;
    
    // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
    previewCardletrasdes.style.color = selectedColorletraspequño; 
})
nombre.addEventListener('input', function() {
    // Obtener el valor de color seleccionado por el usuario
    const selectednombre = nombre.value;
    
    // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
    previewCardnombre.innerText   = selectednombre;
})
descripcion.addEventListener('input', function() {
    // Obtener el valor de color seleccionado por el usuario
    const selectedInformacion = descripcion.value;
    
    // Aplicar el color seleccionado como fondo de la tarjeta de vista previa
    previewCardInform.innerText   = selectedInformacion;
})
;
</script>
@endsection