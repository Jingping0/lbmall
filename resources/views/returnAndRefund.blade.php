<!DOCTYPE html>
<html>
    <head>
        @include('layout.subNav')
        <link rel="stylesheet" href="{{ asset('css/returnAndRefund.css') }}">
        <!-- fontawesome -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <!-- End fontawesome -->
        <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    </head>



    <body>
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

        <div class="root">
            <div class="main_container">
                <div class="main_container_grid">
                    <div class="main_content">
                        <div>
                            <div class="content">
                                <h1 class="returnForm_title">Request Return/Refund</h1>
                                <div class="returnRefund_container">
                                    <div class="retrun_item_container">
                                        <div class="retrun_item">
                                            <div class="retrun_item_wrapper">

                                                @foreach ($order->orderDetails as $detail)
                                                    <div class="item_wrapper">
                                                        <div class="item_grid">
                                                            <div class="image_container">
                                                                @php($product_image =  $detail->productItem['product_image'])
                                                                <img class="return_item_image" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                                            </div>
                                                            <div class="item_details_container">
                                                                <div class="item_details_grid">
                                                                    <div class="item_detail_container">
                                                                        <div class="item_detail_wrapper">
                                                                            <span class="item_name">
                                                                                <a href="" class="item_name_a">
                                                                                    {{ $detail->productItem->product_name }}
                                                                                </a>
                                                                            </span>
                                                                            <span class="item_detail">
                                                                                <div class="category">{{ $detail->productItem->category->category_name }}</div>
                                                                                <div class="detail">{{ $detail->productItem->product_measurement }} cm</div>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item_price">
                                                                        <div class="item_price_wrapper">
                                                                            <span class="item_price_module">
                                                                                <span class="price_currency">RM</span>
                                                                                <span class="price_integer">{{ $detail->productItem->product_price * $detail->quantity }}</span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="items_quantity">
                                                                        <p class="quantity_text">
                                                                            Qty:
                                                                            <span class="quantity_number">{{ $detail->quantity }}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="item_status_container">
                                                                        <div class="item_status_wrapper">
                                                                            <span class="item_status">
                                                                                {{ $detail->order->status }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <form method="POST" action="{{ route('CustReturnAndRefundPost') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('post')
                                                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                                    <div class="return_item_reason_container">
                                                        <div class="return_item_reason_wrapper">
                                                            <div class="return_item_reason_grid">
                                                                <p class="reason_title">Why do you want to refund</p>
                                                                <div class="input_reason_container">
                                                                    <div class="input_reason_wrapper">
                                                                        <div class="input_reason">
                                                                            <label class="input_name">Reason</label>
                                                                            <div class="inputfield">
                                                                                <select name="reason" id="reason" class="inputs">
                                                                                    <option value="" disabled selected>Select Reason</option>
                                                                                    <option value="Missing">Missing quantity/accessories</option>
                                                                                    <option value="Wrong Item">Received wrong item</option>
                                                                                    <option value="Damage Item">Damaged item</option>
                                                                                </select>
                                                                                <span class="input_span"></span>
                                                                            </div>
                                                                            @error('reason')
                                                                                <div class="error-message">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="input_reason_container">
                                                                        <div class="input_reason_wrapper">
                                                                            <div class="input_reason">
                                                                                <label class="input_name">Description</label>
                                                                                <div class="inputfield">
                                                                                    <textarea class="inputs" type="text" name="description" id="description"></textarea>
                                                                                    <span class="input_span"></span>
                                                                                </div>
                                                                                @error('description')
                                                                                    <div class="error-message">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="drop_image_container" id="page" class="site">
                                                                        <div class="file_container">
                                                                            <div class="file_upload">
                                                                                <input type="file" name="evidence" id="evidence" class="file_input" multiple>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="summary1_container">
                                                        <div class="summary1_container_grid">
                                                            <div class="summary1">

                                                                <div class="refund_email_container">
                                                                    <label for="" class="refund_amount_text">Email</label>
                                                                    <div class="refund_email">
                                                                        <span class="email">{{ $order->customer->email }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="refund_to_container">
                                                                    <label for="" class="refund_amount_text">Refund To</label>
                                                                    <div class="refund_to">
                                                                        <span class="refund_to_bank">Online Banking</span>
                                                                    </div>
                                                                </div>

                                                                <div class="refund_amount_container">
                                                                    <label for="" class="refund_amount_text">Refund Amount</label>
                                                                    <div class="refund_amount">
                                                                        <span class="price_currency">RM</span>
                                                                        <span class="price_integer">{{ $order->totalAmount }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="submit_btn_container">
                                                                    <button type="submit" class="submit_btn">
                                                                        <span class="submit_btn_wrapper">Submit</span>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modalImage" style="width: 100%;" alt="Uploaded Image">
        </div>
    </div>

  

    <script>
        function showImage(fileName) {
            // Get the modal and modal image elements
            var modal = document.getElementById('imageModal');
            var modalImage = document.getElementById('modalImage');
    
            // Set the source of the modal image to the selected file
            modalImage.src = 'path/to/your/uploaded/images/' + fileName;
    
            // Display the modal
            modal.style.display = 'block';
        }
    
        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }
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
@include('layout.footer')
<!-- EndFooter -->


</body>
</html>