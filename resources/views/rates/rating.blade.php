<!DOCTYPE html>
<html>
    <head>
        <title>LB | Product</title>
        <link rel="icon" href="image/small_logo.png">
        <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

        <!-- fontawesome -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

	    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <!-- End fontawesome -->

    <!-- header -->
    <section class="header">
        <nav>
            <a href="home.html"><img src="image/small_logo.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-window-close-o" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="home.html">HOME</a></li>

                    <li><div class="dropdown" data-dropdown>
                        <a href="product_filter.html">PRODUCT</a>
                            
                    </li>
                    <li><a href="about.html">ABOUT US</a></li>
                    <li><a href="contact.html">CONTACT US</a></li>
                    <li>
                        <input type="search" id="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search" autocomplete="off">
                        <div class="search-menu" id="search-menu">

                        </div>
                    </li>
                    <li><div class="cart-icon"><a href="wishList.htm"><i class="fas fa-heart" style="font-size:24px"></i></a></div></li>
                    <li><div class="cart-icon"><a href="#"><i class="fas fa-solid fa-truck"></i></a></div></li>
                    <li><div class="cart-icon"><a href="cart.html"><i class="fas fa-shopping-cart fa-"></i></a></div></li>
                    <li><div class="cart-icon"><a href="Userprofile.html"><i class="fas fa-solid fa-user"></i></a></div></li>
                </ul>
            </div>
        </nav>
    </section>
    <!-- EndHeader -->

</head>

<body>
    <div class="root">
        <div class="main_grid">

            <div class="left_container">
                <div class="rating_text_container">
                    <h1 class="rating_text">Rate Product</h1>
                </div>
                <div class="container">
                    
                    <div class="gallery-container w-4 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://source.unsplash.com/1600x900/?Mirror" alt="Mirror"></a>
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-2 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <img src="https://source.unsplash.com/1600x900/?wardrobe" alt="wardrobe">
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-3 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <a href="category/bedpage.html"><img src="https://source.unsplash.com/1600x900/?bed" alt="bed"></a>
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-3 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <img src="https://source.unsplash.com/1600x900/?dinnerware" alt="tableware">
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-2 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <img src="https://source.unsplash.com/1600x900/?mirror" alt="sofa">
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-2 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <img src="https://source.unsplash.com/1600x900/?swiver chair" alt="chair">
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-2 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <a href="category/tablepage.html"><img src="https://source.unsplash.com/1600x900/?table" alt="table"></a>
                            </div>
                        </div>
                    </div>
                
                    <div class="gallery-container w-6 h-1">
                        <div class="gallery-item">
                            <div class="image">
                                <img src="https://source.unsplash.com/1600x900/?plant pot" alt="plant pot">
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="right_container">
               
                    
               
                
                <div class="rating_product_container">
                    <div class="rating_product_grid">
                        <div class="image_container">
                            
                            @php($product_image =  $product_item->product_image)
                            <img class="rating_product_image" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                        </div>
                        <div class="rating_product_details_container">
                            <div class="rating_product_details_grid">
                                <div class="item_detail_container">
                                    <div class="item_detail_wrapper">
                                        <span class="item_name">
                                            <a href="" class="item_name_a">
                                                {{ $product_item->product_name }}
                                            </a>
                                        </span>
                                        <span class="item_detail">
                                            <div class="category">{{ $product_item->category->category_name }}</div>
                                            <div class="detail">{{ $product_item->product_measurement }}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="items_quantity">
                                    <p class="quantity_text">
                                        Qty:
                                        <span class="quantity_number">{{ $product_item->quantity }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form action="{{ $rating
      ? route('ratings.updateRatingPost', ['rating_id' => optional($rating)->rating_id])
      : route('ratings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="rating_star_container">
                        <label class="rating_product_reason_name">Product Quality</label>
                        <div class="rating_star_wrapper">
                            <input class="radio_star" type="radio" name="rating_value" id="rate-5" value="5">
                            <label for="rate-5" class="rating_star_icon fas fa-star"></label>
                            <input class="radio_star" type="radio" name="rating_value" id="rate-4" value="4">
                            <label for="rate-4" class="rating_star_icon fas fa-star"></label>
                            <input class="radio_star" type="radio" name="rating_value" id="rate-3" value="3">
                            <label for="rate-3" class="rating_star_icon fas fa-star"></label>
                            <input class="radio_star" type="radio" name="rating_value" id="rate-2" value="2">
                            <label for="rate-2" class="rating_star_icon fas fa-star"></label>
                            <input class="radio_star" type="radio" name="rating_value" id="rate-1" value="1">
                            <label for="rate-1" class="rating_star_icon fas fa-star"></label>
                        </div>
                    </div>
                
                    <div class="rating_product_reason_container">
                        <div class="rating_product_reason_wrapper">
                            <div class="rating_product_reason">
                                <label class="rating_product_reason_name">Description</label>
                                <div class="rating_product_reason_inputfield">
                                    <textarea class="rating_product_reasons" type="text" name="rating_comment" value="rating_comment"></textarea>
                                    <span class="rating_product_reason_span"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="drop_image_container" id="page" class="site">
                        <label class="rating_product_reason_name">Add 1 photo</label>
                        <div class="file_container">
                            <div class="file_upload">
                                <input type="file" name="rating_image" id="" class="file_input" value="rating_image">
                                <h3 class="drop_text">Drag & Drop here</h3>
                                <span>- OR -</span>
                                <strong>Browse</strong>
                                <button class="add_file">
                                    <i class="add_file_icon bx bx-x" name="close"></i>
                                </button>
                            </div>
                            <div class="list_upload">
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="product_item_id" value="{{ $product_item->product_item_id }}">

                    <div class="submit_btn_container">
                        <a href="{{ url()->previous() }}" class="back_btn">Back</a>
                        <button type="submit" class="submit_btn">
                            <span class="submit_btn_wrapper">Submit</span>
                        </button>
                    </div>
                  
                    </form> 
                    
                        
                    
                     
                    
                
                
    
            </div>

        </div>                   
    </div>

    <script>
        $(document).ready(function () {
            // Intercept the main form submission
            $("#mainForm").submit(function (e) {
                e.preventDefault(); // Prevent the default form submission
    
                // Submit the nested form using AJAX
                $.ajax({
                    url: "{{ route('upload') }}",
                    type: "POST",
                    data: new FormData($("#nestedForm")[0]),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        // Handle success if needed
                        console.log("Nested form submitted successfully");
    
                        // Continue with the submission of the main form
                        $("#mainForm").unbind('submit').submit();
                    },
                    error: function (xhr, status, error) {
                        // Handle error if needed
                        console.error("Error submitting nested form");
                    }
                });
            });
        });
    </script>
    
    <script>
        // Add this script to handle the click event
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.querySelector('.inputs');
        
            select.addEventListener('click', function () {
                // Toggle the 'open' class
                select.classList.toggle('open');
            });
        
            // Add the file upload code here
            document.querySelector('.file_input').addEventListener('change', function () {
                // ... (rest of the code)
            });
        });
    </script>


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

<div class="footer">
    <hr>
    <br>
    <div class="footer_content">
    <div class="container_footer">
        <div class="row">
            <div class="">
                
                <h4>LB Family</h4>
                <ul>
                    <p class="inf">Some clubs are for the select few, but LB<br>
                        Family is for everyone. Become a Family<br> 
                        member and enjoy rewards, discounts,<br> 
                        inspirations and a few surprises all year<br> 
                        round.</p>

                    <div class="member_btn">
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><button name="submit" class="btn">Join for free</button></a>
                    </div>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Shop at LB</h4>
                <ul>
                    <li><a href="#">Product offers</a></li>
                    <li><a href="#">New products</a></li>
                    <li><a href="#">Planning tools</a></li>
                    <li><a href="#">Store information</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Customer service</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Delivery</a></li>
                    <li><a href="#">Return policy</a></li>
                    <li><a href="#">Track your order</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>This is LB</h4>
                <ul>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">LB Family</a></li>
                    <li><a href="#">LB for Business</a></li>
                    <li><a href="#">Catalogues & everyday</a></li>
                </ul>
            </div>

            <div class="footer-col"> 
                <h4>News & media</h4>
                <ul>
                    <li><a href="#">Corporate news</a></li>
                    <li><a href="#">Product recalls</a></li>
                    <li><a href="#">Secure it or Return it!</a></li>
                    <li><a href="#">Product loan</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="social_media">
        <ul>
            <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E"><i class="fab fa-instagram"></i></a></li>
            <li><a href="https://www.youtube.com/watch?v=UXiwRmlCZ7E"><i class="fab fa-youtube"></i></a></li>
        </ul>
    </div>

    <hr class="line">

    <p class="inf">
        © Inter Lb Systems B.V. 2022-2022
    </p>

    <p class="inf">Karyuuno Tekken Sdn. Bhd. (Company Registration No. 101010101010 (1326497-A))</p>
</div>
</div>

<!-- EndFooter -->


</body>
</html>