<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
        <!---box icon link-->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../css/admin_nav.css" type="text/css">
        <link rel="stylesheet" href="../css/admin_product.css" type="text/css">

        <title>Navbar</title>

    </head>

    <body>
        {{-- @include('nav') --}}
        <!--action--->
        <script>
            let arrow = document.querySelectorAll('.arrow');

            for (var i = 0; i < arrow.length; i++) {
                arrow[i].addEventListener("click", (e) => {
                    let arrowParent = e.target.parentElement.parentElement;
                    console.log(arrowParent);
                    arrowParent.classList.toggle("showMenu");
                });
            }
        </script>
        <!--action--->
        <script>
            let btn = document.querySelector("#btn");
            let sidebar = document.querySelector(".sidebar");
            let searchBtn = document.querySelector(".bx-search");

            btn.onclick = function () {
                sidebar.classList.toggle("active");
            }

            searchBtn.onclick = function () {
                sidebar.classList.toggle("active");
            }
        </script>
        <!---serach---->
        <script>

            const searchFunction = () => {
                let filter = document.getElementById('myInput').value.toUpperCase();

                let myTable = document.getElementById('myTable');

                let tr = myTable.getElementsByTagName('tr');

                for (var i = 0; i < tr.length; i++) {
                    let td = tr[i].getElementsByTagName('td')[2];

                    if (td) {
                        let textvalaue = td.textContent || td.innerHTML;

                        if (textvalaue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>


        <!----main----->

        <h1 class="text">Address List</h1>
        
        <div class="search">
            <input type="text" class="search-bar" placeholder="Search..." id="myInput" onkeyup="searchFunction()">
        </div>
        

        @if (session('success'))
        <div class="alert alert-success" role="success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="header_fixed">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Phone Number</th>    
                        <th>Street</th>
                        <th>Area</th>
                        <th>Post Code</th>

                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1 @endphp
                    @foreach($addresses as $address)
                    <tr>
                        <td>{{ $counter++  }}</td>
                        <td>{{ $address->user_id }}</td>
                        <td>{{ $address->username }}</td>
                        <td>{{ Str::limit(decrypt($address->address_userphone),20) }}</td>
                        <td>{{ $address->street }}</td>
                        <td>{{ $address->area }}</td>
                        <td>{{ $address->postcode }}</td>

                        <div class="report">
                            <a class="btn-report" href="{{ route('addressReport', ['address' => $address->user_id]) }}">Generate Report</a>
                        </div>

                        <td><a href="{{ route('address.staffEdit', $address->address_id) }}"><button>Edit</button></a></td>
                        
                        <td>
                            <form action="{{ route('address.staffDestroy', $address->address_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>