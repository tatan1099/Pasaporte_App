<html lang="es">
@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 ">
                <div class="cajacrearevento">
                    <div class="containerimgtitleevento">
                        <img class="logo-visitadosEvent d-block" src="{{ asset('images/Crearevento.png') }}" alt="">
                        <span class="tittleEvent_1 d-inline-block">Evento</span>
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
                    <form id="event-form " action="{{ route('UserEvent.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="inputscrearevento">
                            <!-- Campo para el nombre del evento -->
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="input-evento" class="label_color">Nombre evento</label>
                                <input type="text" id="input-eventonombre" name="name" class="form-espacioseventos " required autocomplete="off" placeholder="Nombre evento" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                            </div>
                            <!-- Campo para cargar el logo -->
                            <div class="formEvent rounded col-md-8 d-flex-block ">
                                <label for="logo" class="label_color form-label">Logo URL</label>
                                <input type="file" class="form-espacioseventos input-register " name="logo" accept="image/*" required>
                            </div>
                            <!-- Campo para cargar el banner -->
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="banner" class="label_color form-label">Banner URL (tamaño máximo 632x350 pixeles)</label>
                                <input type="file" class="form-espacioseventos input-register" id= "banner" name="banner" accept="image/*" required>
                            </div>
                            <!-- Campo para la descripción -->
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label class="label_color">Información del evento</label>
                                <textarea class="form-espacioseventos input-evento   " id="input-eventoinformación" placeholder="Descripción" name="description" required></textarea>
                            </div>
                            <!-- Campos para las redes sociales -->
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="input-eventofacebook" class="label_color">Facebook</label>
                                <input type="url" id="input-eventofacebook" class="form-espacioseventos input-evento " name="facebook"
                                placeholder="Facebook" pattern="https:\/\/(www\.)?facebook\.com\/.*">
                            </div>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="input-eventoinstagram" class="label_color">Instagram</label>
                                <input type="url" id="input-eventoinstagram" class="form-espacioseventos input-evento  " name="instagram"
                                placeholder="Instagram" pattern="https:\/\/(www\.)?instagram\.com\/.*">
                            </div>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="input-eventotiktok" class="label_color">TikTok</label>
                                <input type="url" id="input-eventotiktok" class="form-espacioseventos input-evento  " name="tiktok"
                                placeholder="TikTok" pattern="https:\/\/(www\.)?tiktok\.com\/.*">
                            </div>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="input-eventopagina" class="label_color">Página web</label>
                                <input type="url" id="input-eventopagina" class="form-espacioseventos input-evento " name="web"
                                placeholder="Página web" pattern="https:\/\/.*">
                            </div>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="floatingInput" class="label_color">Fecha de Inicio</label>
                                <input type="date" id="fechainicio" class="form-espacioseventos input-evento " name="fechainicio" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="fechaFin" class="label_color">Fecha Fin </label>
                                <input type="date" id="fechaFin" class="form-espacioseventos input-evento   "  name="fechaFin" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                            <hr>
                            <!-- Campo para seleccionar el primer color del stand -->
                            <i class='PaintRollerfondoeven bx bxs-paint-roll bx-flip-horizontal bx-border-circle' style="color:#ffffff" ></i>
                            <div class="formEvent rounded col-md-8 d-flex-block">  
                                <label for="color_contenedor_1" class="label_fondograndeeve">Color de fondo principal</label>
                                <input type="color" id="input-eventofondogrande" class="form-espacioseventos " name="color_contenedor_1" value="#ffffff">
                            </div>
                            <i class='PaintRollercreateevento1 bx bx-paint bx-border-circle' style="color:#ffffff" ></i>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="color_contenedor_2" class="label_letrastituloevento">Color de letras titulo </label>
                                <input type="color" id="input-eventoletrastit" class="form-espacioseventos " name="color_contenedor_2" value="#ffffff">
                            </div>
                            <i class='PaintRoller_1 bx bxs-paint-roll bx-flip-horizontal bx-border-circle' style="color:#ffffff" id="PaintRoller_1"></i>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="color_contenedor_3" class="form-labelcolores label-colores1 label-register">Color de fondo encabezado</label>
                                <input type="color" id="input-eventoencabezado" class="form-espacioseventos input-register separacionentrelabels   " name="color_contenedor_3" value="#000000">
                            </div>
                            <!-- Campo para seleccionar el segundo color del stand -->
                            <i class='Paint_1 bx bx-paint bx-rotate-270 bx-border-circle' style="color:#ffffff" id="Paint_1"></i>
                            <div class="formEvent rounded col-md-8 d-flex-block">
                                <label for="color_contenedor_4" class="form-labelcolores label-colores1 label-register  ">Color de letras pequeñas</label>
                                <input type="color" id="input-eventoletraspequeñas" class="form-espacioseventos input-register    " name="color_contenedor_4" value="#ffffff">
                            </div>
                            <!-- Contenedor del segundo carrusel -->
                            <div class="formEvent_1 col-md-8 d-flex-block">
                                <label for="numero_imagenes" class="label_color posicionlabel">Selecciona la cantidad de imágenes para los stands</label>
                                <select name="numero_imagenes" id="numero_imagenes" class="form-controlnumeroimagenes input-register form-espacioseventos00 ">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <label for="numero_imagenes" class="label_color form-labelseleccciónimagenesevento">Selecciona las imagenes para el evento (tamaño máximo  1004x591 pixeles) </label>
                            @for ($i = 1; $i <= 8; $i++)
                                <div class="formEvent_1 col-md-8 d-flex-block" id="image{{ $i }}">
                                    <label for="images{{ $i }}" class="label_color"></label>
                                    <input type="file" class="form-controlimegenesdelevento input-register image-input " id="images{{ $i }}" name="images{{ $i }}" accept="image/*" placeholder="Limite de tamaño 1004x591 pixeles">
                                    <!-- <button type="button" class="btnElim btn  delete-image" id="btnElim">Eliminar</button> -->
                                    <button type="button" class="btnElim btn delete-image" data-index="{{ $i }}">Eliminar</button>
                                </div>
                            @endfor
                        </div>
                        <div class="stand-visualizacionvistapreviaevento" id="vistapreviaevento">
                            <li class="stands-visualizacionnombre   align-items-center text-center" id="contenedorpe">
                                <label  class="label_colorvistaprevianombrevento" id="nombreevento">Nombre del evento</label>
                            </li>
                            <label class="label_infovistaprevianombrevento" id="informacióndeleve">Información del evento:</label>
                            <div class="carousel-containerGenerare d-flex align-items-center">
                                
                                <!-- Botón de anterior del segundo carrusel -->
                                <button type="button" class="prevcrearevento" onclick="prevImage2()">&#10094; Anterior</button>
                                <div id="carousel-inerE" class="carouseleventocrear mx-3"></div>
                                <!-- Botón de siguiente del segundo carrusel -->
                                <button type="button" class="nextGenerareventoEVENTO" onclick="nextImage2()">Siguiente &#10095;</button>
                            
                            </div>
                        </div>
                        <!-- Botones para enviar y volver -->
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" id="btnEnviarcrearevento" class="btnEnviarcrearevento btn  btn-submit">Enviar</button>
                                <a href="{{ route('UserEvent.listaeventos') }}" id ="btnVolvercrearevento" class=" btn  " id="btnVolver">Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const defaultUrls = {
                'input-eventofacebook': 'https://www.facebook.com/',
                'input-eventoinstagram': 'https://www.instagram.com/',
                'input-eventotiktok': 'https://www.tiktok.com/',
                'input-eventopagina': 'https://www.example.com/'
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
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            handleDeleteImage(index);
        });
    });

    function handleDeleteImage(index) {
        const fileInput = document.getElementById(`image${index}`);
        fileInput.value = ''; // Limpiar el campo de archivo

        const imageToRemove = document.querySelector(`#carousel-inner img:nth-child(${index})`);
        if (imageToRemove) {
            imageToRemove.remove(); // Eliminar la imagen del carrusel
        }
    }
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
                    alert(`Las dimensioness de la imagen son mayores a  ${maxWidth}x${maxHeight} píxeles.`);
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
    const maxFileSize = 3 * 1024 * 1024; // 3MB en bytes
const maxWidth = 1004; // Ancho máximo en píxeles
const maxHeight = 591; // Alto máximo en píxeles

let currentIndex = 1;
const intervalTime = 4000;
let interval;

// Función para eliminar la última imagen del carrusel
function handleDeleteLastImage() {
    const images = document.querySelectorAll('#carousel-inerE img');
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
    const carousel = document.getElementById('carousel-inerE');

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
    const images = document.querySelectorAll('.carouseleventocrear img');
    images.forEach((img, i) => {
        img.style.display = (i === index) ? 'block' : 'none';
    });
    currentIndex = index;
}

// Función para cambiar a la siguiente imagen en el carrusel
function nextImage2() {
    const images = document.querySelectorAll('.carouseleventocrear img');
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
}

// Función para cambiar a la imagen anterior en el carrusel
function prevImage2() {
    const images = document.querySelectorAll('.carouseleventocrear img');
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
}

// Evento que se dispara cuando la página se ha cargado completamente
document.addEventListener('DOMContentLoaded', () => {
    startCarousel();
});

// Escuchar el evento input de los campos de imagen
['images1', 'images2', 'images3', 'images4', 'images5', 'images6', 'images7', 'images8'].forEach((id, index) => {
    document.getElementById(id).addEventListener('input', function() {
        handleImageInputChange(this, index);
    });
});

// Función para manejar la eliminación manual de imágenes
function handleDeleteImage(index) {
    const fileInput = document.getElementById(`images${index}`);
    fileInput.value = ''; // Limpiar el campo de archivo

    const imageToRemove = document.querySelector(`#carousel-inerE img:nth-child(${index})`);
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
    // Variable para mantener el índice de la imagen actual
    let currentIndex = 1;
    // Intervalo de tiempo en milisegundos (2 segundos en este ejemplo)
    const intervalTime = 4000;
    // Variable para el intervalo del carrusel
    let interval;
    function handleImageInputChange(input, index) {
        const fileInput = input;
        const carousel = document.getElementById('carousel-inerE');

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
            const imageToRemove = document.querySelector(`#carousel-inerE img:nth-child(${index})`);
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
        const images = document.querySelectorAll('.carouseleventocrear img');
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
        const images = document.querySelectorAll('.carouseleventocrear img');
        // Actualizar el índice de la imagen actual
        currentIndex = (currentIndex + 1) % images.length;
        // Mostrar la imagen actualizada
        showImage(currentIndex);
    }

    // Función para cambiar a la imagen anterior en el carrusel
    function prevImage2() {
        const images = document.querySelectorAll('.carouseleventocrear img');
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
    document.getElementById('images1').addEventListener('input', function() {
        handleImageInputChange(this, 1);
    });

    // Escuchar el evento input del campo image2
    document.getElementById('images2').addEventListener('input', function() {
        handleImageInputChange(this, 2);
    });

    // Escuchar el evento input del campo image3
    document.getElementById('images3').addEventListener('input', function() {
        handleImageInputChange(this, 3);
    });

    // Escuchar el evento input del campo image4
    document.getElementById('images4').addEventListener('input', function() {
        handleImageInputChange(this, 4);
    });

    // Escuchar el evento input del campo image5
    document.getElementById('images5').addEventListener('input', function() {
        handleImageInputChange(this, 5);
    });

    // Escuchar el evento input del campo image6
    document.getElementById('images6').addEventListener('input', function() {
        handleImageInputChange(this, 6);
    });

    // Escuchar el evento input del campo image7
    document.getElementById('images7').addEventListener('input', function() {
        handleImageInputChange(this, 7);
    });

    // Escuchar el evento input del campo image8
    document.getElementById('images8').addEventListener('input', function() {
        handleImageInputChange(this, 8);
    });

    // Función para manejar el cambio en los campos de imagen
    function handleImageInputChange(input, index) {
        const fileInput = input;
        const carousel = document.getElementById('carousel-inerE');

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
</script>


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
  const colorInput = document.getElementById('input-eventofondogrande');
  const nombre = document.getElementById('input-eventonombre');
  const descripcion = document.getElementById('input-eventoinformación');
  const previewCard = document.getElementById('vistapreviaevento');
  const colorLetrastitulo = document.getElementById('input-eventoletrastit');
  const fondoencabezado = document.getElementById('input-eventoencabezado');
  const aplicacionpeque = document.getElementById('contenedorpe');
  const colorLetraspequeño = document.getElementById('input-eventoletraspequeñas');
  const previewCardletrastitulo = document.getElementById('nombreevento');
  const previewCardletrasdes = document.getElementById('informacióndeleve');
  const previewCardletrasredes = document.getElementById('redes');
  const previewCardnombre = document.getElementById('nombreevento');
  const previewCardInform = document.getElementById('informacióndeleve');

  // Escuchar cambios en el input de color
  colorInput.addEventListener('change', function() {
      // Obtener el valor de color seleccionado por el usuario
      const selectedColor = colorInput.value;
      
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
<script>
document.querySelectorAll('.delete-image').forEach(button => {
    button.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        handleDeleteImage(index);
    });
});

function handleDeleteImage(index) {
    const fileInput = document.getElementById(`images${index}`);
    fileInput.value = ''; // Limpiar el campo de archivo

    const imageToRemove = document.querySelector(`#carousel-inerE img:nth-child(${index})`);
    if (imageToRemove) {
        imageToRemove.remove(); // Eliminar la imagen del carrusel
    }
}
</script>




@endsection
</html>