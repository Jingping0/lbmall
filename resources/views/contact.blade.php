<!DOCTYPE html>

<html>
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title> LB </title>
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+SC:wght@300;400;500;700;800&display=swap"
              rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

        <!--MAP-->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
        <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.1/mapbox-gl.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <script src="{{ asset('js/dropdown.js') }}" defer></script>
        <script src="{{ asset('js/search.js') }}" defer></script>
        <script src="{{ asset('js/profile.js') }}" defer></script>
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    </head>

    @if (session('success'))
    <div class="wrapperT">
        <div class="toast toast_success" id="my-container">
            <div class="container">
                <span class="icon">
                    <i class='bx bx-check-circle'></i>
                </span>
                <div id="my-message" class="alert alert-success" role="alert">
                    <span class="message">{{ session('success') }}</span>
                </div>
                <span class="close-icon" onclick="closeToast()">
                    <i class='bx bx-x'></i>
                </span>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var toast = document.getElementById("my-message");
            var toastContainer = document.getElementById("my-container");

            setTimeout(function(){
                toast.style.opacity = "1";
                toastContainer.style.opacity = "1";

                setTimeout(function() {
                    closeToast();
                }, 2000);
            }, 50);
        };

        const closeToast = () => {
            var toast = document.getElementById("my-message");
            var toastContainer = document.getElementById("my-container");

            // Add transition properties to smoothly move to the right
            toast.style.transition = "opacity 0.5s, transform 0.5s";
            toastContainer.style.transition = "opacity 0.5s, transform 0.5s";

            toast.style.opacity = "0";
            toastContainer.style.opacity = "0";
            toastContainer.style.transform = "translateX(100%)"; // Move to the right

            // Remove the toast after the transition ends
            setTimeout(() => {
                toast.style.transition = "none";
                toastContainer.style.transition = "none";
                toastContainer.style.transform = "none";
            }, 500); // Assuming the transition duration is 0.5s
        };
    </script>
    @endif
    <body>
        @include('layout.subNav')

            <div class="contactUs">
                <div class="title">
                    <h2 class="contact_title">Contact Us</h2>
                </div>
                <div class="box">
                    <div class="contact form">
                        <form action="{{ route('contact.createRequest') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h3>Send a Message</h3>
                            <div class="formBox">
                                <div class="row50">
                                    <div class="inputBox">
                                        <select class="issue_type_wrapper" name="issue_type" id="issue_type" required>
                                            <option value="" disabled selected>Select Issue Type</option>
                                            <option value="Payment" @if(old('issue_type') == 'Payment') selected @endif >Payment</option>
                                            <option value="Shipping" @if(old('issue_type') == 'Shipping') selected @endif>Shipping</option>
                                            <option value="Order" @if(old('issue_type') == 'Order') selected @endif >Order</option>
                                            <option value="General Enquireies" @if(old('issue_type') == 'General Enquireies') selected @endif>General Enquireies</option>
                                        </select>
                                        @error('issue_type')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                                <div class="row100">
                                    <div class="inputBox">
                                        <textarea class="cust_service_desc_wrapper" id="cust_service_desc" name="cust_service_desc" placeholder="Write your message here..." required></textarea>
                                    </div>
                                    @error('cust_service_desc')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row100">
                                <div class="drop_image_container" id="page" class="site">
                                    <div class="file_container">
                                        <div class="file_upload">
                                            <input type="file" name="cust_service_image" id="cust_service_image" class="file_input">
                                            <h3 class="drop_text">Drag & Drop here</h3>
                                            <span>- OR -</span>
                                            <strong>Browse</strong>
                                            <button class="add_file">
                                                <i class="add_file_icon bx bx-x" name="close"></i>
                                            </button>
                                        </div>
                                        @error('cust_service_image')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                        <div class="list_upload">
                                            <ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>
                        
                                <div class="row100">
                                    <div class="inputBox">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                        
        
                    </div>
                    <!-- info box ---->
                    <div class="contact info">
                        <h3>Contact Info</h3>
                        <div class="infoBox">
                            <div>
                                <span>
                                    <ion-icon name="location-outline"></ion-icon>
                                </span>
                                <p>13A-D, Holiday Villa, Megan Ambassy, Jln Ampang, Taman U Thant, 50450 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
                            </div>
                            <div>
                                <span>
                                    <ion-icon name="mail-outline"></ion-icon>
                                </span>
                                <a href="mailto:jingpingchiang@gmail.com">lb@gmail.com</a>
                            </div>
                            <div>
                                <span>
                                    <ion-icon name="call-outline"></ion-icon>
                                </span>
                                <a href="tel:+601111299089">+6012345678</a>
                            </div>
        
                        </div>
                        <!----media social---->
                        <div class="sci">
                            <ul>
                                <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E">
                                        <ion-icon name="logo-facebook"></ion-icon>
                                    </a></li>
                                <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E">
                                        <ion-icon name="logo-twitter"></ion-icon>
                                    </a></li>
                                <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E">
                                        <ion-icon name="logo-instagram"></ion-icon>
                                    </a></li>
                                <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E">
                                        <ion-icon name="logo-youtube"></ion-icon>
                                    </a></li>
                            </ul>
                        </div>
        
                    </div>
                    <div class="contact map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d127477.994299975!2d101.57176388192019!3d3.176744621371769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e0!4m0!4m5!1s0x31cc4e81e4ea9b6f%3A0x95d0b7303d406a0b!2sEzyOffice%20(Ezy%20%26%20Associates%20Sdn.%20Bhd.)!3m2!1d3.1546195!2d101.594087!5e0!3m2!1sen!2smy!4v1763715328754!5m2!1sen!2smy"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        
        <!--icon---->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <!--MAP-->
        <div class="border"></div>
        <div id="mapid"></div>
        <script>

            mapboxgl.accessToken = 'pk.eyJ1IjoieWlzaGVuZzIwMDIiLCJhIjoiY2thdzV4cmVxMG1vNzJybzVlMHVhdTR6MSJ9.INKTMrf7oM0zXZ_U7gT79Q';

            var mymap = L.map('mapid').setView([3.21620, 101.72896], 18);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {

                maxZoom: 20,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: mapboxgl.accessToken,

            }).addTo(mymap);
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
                    $(document).ready(function () {
                        $("#search").keyup(function () {

                            // Retrieve the input field text and reset the count to zero
                            var filter = $(this).val();
                            // get the list to be searched
                            var items = $(".search-content button");

                            // Loop through the comment list
                            $(".search-content button").each(function () {

                                // If the list item does not contain the text phrase fade it out
                                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                    $(this).hide();

                                    // Show the list item if the phrase matches and increase the count by 1
                                } else {
                                    $(this).show();
                                }
                            });
                        });
                        $("#search").focus(function () {
                            $("#search-content").show();
                        });

                    });
        </script>

    </section>

    <script>
        document.querySelector('.file_input').addEventListener('change', function () {
            let allowed_mine_types = [];
    
            // allowed max size in MB
            let allowed_size_mb = 100;
    
            var files_input = document.querySelector('.file_input').files;
            // user has not chosen any file
            if (files_input.length == 0) {
                alert('Error: No file selected');
                return;
            }
            for (let i = 0; i < files_input.length; i++) {
                let file = files_input[i];
                
    
                // validate file size
                if (file.size > allowed_size_mb * 1024 * 1024) {
                    alert('Error: Exceed size => ' + file.name);
                    return;
                }
                
                let uniq = 'id-' + btoa(file.name).replace(/=/g, '').substring(0, 7);
                let filetype = file.type.match(/([^\/]+)\//);            
    
                let li = `
                <li class="file_list ${filetype[1]}" id="${uniq}" data-filename="${file.name}" >
                    <div class="thumbnail" onclick="showImage('${file.name}')">
                        <i class="image_icon bx bx-image" name="image_outline"></i>
                        <i class="image_icon bx bx-video" name="videocam_outline"></i>
                        <span class="complete">
                            <i class="bx bx-check" name="checkmark"></i>
                        </span>
                    </div>
                                <div class="properties" >
                                    <span class="titles">${file.name}</span>
                                    <span class="size">${bytesToSize(file.size)}</span>
                                    <span class="progress">
                                        <span class="buffer"></span>
                                        <span class="percentage">0%</span>
                                    </span>
                                </div>
                                <button class="remove ${filetype[1]}">
                                    <i class="bx bx-x" name="close"></i>
                                </button>
                            </li>`;
    
                document.querySelector('.list_upload ul').innerHTML = li + document.querySelector('.list_upload ul').innerHTML;
                let li_el = document.querySelector('#' + uniq);
    
                // upload file now
                var data = new FormData();
    
                // file selected by the user - in case of multiple files append each of them
                data.append('file', file);
                            
                var request = new XMLHttpRequest();
                request.open('POST', 'upload.php');
    
                // upload progress event
                request.upload.addEventListener('progress', function (e) {
                    let li_el = document.querySelector('#'+uniq);
                    let percent = Math.ceil((e.loaded / e.total) * 100);
                    li_el.querySelector('.buffer').style.width = percent + '%';
                    li_el.querySelector('.percentage').innerHTML = percent + '%';
                    li_el.querySelector('.percentage').style.left = percent + '%';
    
                    if (e.loaded == e.total) {
                        li_el.querySelector('.complete').style.display = li_el.querySelector('.remove').style.display = 'flex';
                        li_el.querySelector('.remove').addEventListener('click', function () {
                            var data = new FormData();
                            data.append('.removefile', file.name);
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'upload.php', true);
                            xhr.onload = function () {
                                // do something to respond
                                console.log(this.responseText);
                                li_el.remove();
                            };
                            xhr.send(data);
                        });
                    }
                });
    
                // Ajax request finished event
                request.addEventListener('load', function (e) {
                    console.log(request.response);
                });
                // send POST request to the server-side script
                request.send(data);
            }
        });
    
        function bytesToSize(bytes) {
            const units = ["byte", "kilobyte", "megabyte", "terabyte", "petabyte"];
            const unit = Math.floor(Math.log(bytes) / Math.log(2014));
            return new Intl.NumberFormat("en", { style: "unit", unit: units[unit] }).format(bytes / 1024 ** unit);
        }
    </script>
        <!-------FOOTER--------->
    @include('layout.footer')

</html>