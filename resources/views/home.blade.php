<!DOCTYPE html>
<html>

@include('layout.nav')

<body>
    <div class="content">

   
    <!--- Welcome --->
    <h1 class="welcome">Welcome {{auth()->user()->username}}</h1>
    <p class="welcome_a">to LBMALL</p>

    <!---  --->
    <div class="pub_container">
        <h2 class="pub_h2">Building Materials and Solutions for a More Efficient Project</h2>
    </div>
    <p class="inf">On every construction site, some materials are best kept easily accessible for everyday use, while others are better stored safely and organized until needed.<br>
        Whether you’re looking for basic construction materials, decorative finishes, or professional engineering products, we provide smart, efficient, and tailored purchasing and management solutions. Start your project with well-organized materials that save time, labor, and cost.</p>


<div class="pub_container2">
    <h2 class="pub_h2">Trending / Popular Materials</h2>
</div>

<div class="carousel js-flickity"
     data-flickity='{ "wrapAround": true, "autoPlay": 2500, "pauseAutoPlayOnHover": true }'>
   
     @foreach($popularProducts as $product)
        <div class="cell">
            <img src="{{ asset('storage/'.$product->product_image) }}" alt="image">
            <p>{{ $product->product_name }}</p>
            <p>RM {{ number_format($product->product_price, 2) }}</p>

            <small>🔥 Popularity: {{ $product->popularity_score }}</small>
        </div>
    @endforeach
</div>

    <!--- Home --->
    <div class="pub_container">
        <h2 class="pub_h2">Shop materials for more sustainable and efficient construction</h2>
    </div>
    <!---------carsousel---------->
    <div class="main-carousel">
        <div class="cell"><img src="img/img1.png"></div>
        <div class="cell"><img src="img/img2.jpeg"></div></a>
        <div class="cell"><img src="img/img3.jpg"></div>
        <div class="cell"><img src="img/img4.jpg"></div>
        <div class="cell"><img src="img/img5.jpg"></div>
        <div class="cell"><img src="img/img6.jpg"></div>
        <div class="cell"><img src="img/img7.jpg"></div>
        <div class="cell"><img src="img/img8.jpg"></div>   
    </div>


    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
                                $('.main-carousel').flickity({
                                // options
                                cellAlign: 'left',
                                        wrapAround: true,
                                        freeScroll: true
                                });
    </script>

    <div class="pub_container2">
        <h2 class="pub_h2">Storage solutions specifically designed to meet your project needs</h2>
    </div>
    <p class="inf">We understand that demands on construction sites change rapidly<br>
        Materials, tools, and equipment come and go, and your storage must keep pace.<br>
        Our durable, efficient, and practical construction storage solutions meet your project's requirements.
    </p>
    <div><img class="pub_store" src="img/material.webp"></div>
    </div>
    <!---------carsousel 2---------->
   


<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script>
                                $('.main-carousel').flickity({
                                // options
                                cellAlign: 'left',
                                        wrapAround: true,
                                        freeScroll: true
                                });</script>

<!-------->
<div class="pub_container2">
    <h2 class="pub_h2">More ideas and inspiration</h2>
</div>

<div class="container">

    <div class="gallery-container w-3 h-3">
        <div class="gallery-item">
            <div class="image">
                <a href="http://127.0.0.1:8000/product_items?category=9001"><img src="img/materials.webp" alt="Materials"></a>
            </div>
            <div class="text">Materials</div>
        </div>
    </div>

    <div class="gallery-container w-3 h-3">
        <div class="gallery-item">
            <div class="image">
                <a href="http://127.0.0.1:8000/product_items?category=9002"><img src="img/panel.png" alt="Panels & Surface Finishes"></a>
            </div>
            <div class="text">Panels & Surface Finishes</div>
        </div>
    </div>

    <div class="gallery-container w-2 h-2">
        <div class="gallery-item">
            <div class="image">
                <a href="http://127.0.0.1:8000/product_items?category=9003"><img src="img/hardware.webp" alt="Hardware & Tools"></a>
            </div>
            <div class="text">Hardware & Tools</div>
        </div>
    </div>

    <div class="gallery-container w-2 h-2">
        <div class="gallery-item">
            <div class="image">
                <a href="http://127.0.0.1:8000/product_items?category=9004"><img src="img/coat.jpg" alt="Coatings & Chemicals"></a>
            </div>
            <div class="text">Coatings & Chemicals</div>
        </div>
    </div>

    <div class="gallery-container w-2 h-1">
        <div class="gallery-item">
            <div class="image">
                <a href="http://127.0.0.1:8000/product_items?category=9005"><img src="img/plumb.jpg" alt="Plumbing & Electrical">></a>
            </div>
            <div class="text">Plumbing & Electrical</div>
        </div>
    </div>

    <div class="gallery-container w-2">
        <div class="gallery-item">
            <div class="image">
                <a href="http://127.0.0.1:8000/product_items?category=9006"><img src="img/other.webp" alt="Other"></a>
            </div>
            <div class="text">others</div>
        </div>
    </div>

</div>



<div class="pub_container2">
    <h2 class="pub_h2">Furniture and home inspiration</h2>
</div>
<p class="inf">For more than 70 years, we have worked to create a better everyday life for the many people. As a furniture and home<br> 
    furnishing store, we do this by producing furniture and accessories that are well-designed, functional and affordable.<br> 
    ere you will find everything from bedroom furniture, sofas, dining tables, chairs, wardrobes, textiles, cookware,<br>    
    decorations and more. Discover our wide range of products in-store or online!</p>    

</div>

<!-------FOOTER--------->

@include('layout/footer')

<!-- EndFooter -->
<script>

    $(document).ready (function(){
    $('#search').keyup(function(){
    var search = $('#search').val();
    if (search !== "" && search !==null)
    {
    $.ajax({
    type: 'POST',
            url: 'searchResult.html',
            data: 'key=' + search,
            success:function (data)
            {
            $('#search-menu').html(data);
            }
    });
    }
    else
    {
    $(#showList').html();
    });
    $(document).on('click', 'li', function(){
    $('#search').val($(this).text());
    });
    });
</script>

</script>

</body>
</html>