<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Products Table</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('sbadmin2.components.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('sbadmin2.components.header')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <a href="{{ route('admin.products.create') }}" class="text-blue-600" style="float: right">Create Product</a>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Products Table</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product ID</th>
                                            <th>Category ID</th>
                                            <th>Brand ID</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Is Active</th>
                                            <th>Price</th>
                                            <th>Discount Price</th>
                                            <th>Currency</th>
                                            <th>Stock</th>
                                            <th>Option ID</th>
                                            <th>Option Value ID</th>
                                            <th>Created at</th>
                                            <th>Updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productVariants as $productVariant)
                                            <tr>
                                                <td>{{ $productVariant->id }}</td>
                                                <td>{{ $productVariant->product->name }}</td>
                                                <td>{{ $productVariant->product->category->name  }}</td>
                                                <td>{{ $productVariant->product->brand->name ?? null }}</td>
                                                <td>{{ $productVariant->product->name }}</td>
                                                <td>{{ $productVariant->product->slug }}</td>
                                                <td>{{ $productVariant->product->description }}</td>
                                                <td>{{ $productVariant->product->image }}</td>
                                                <td>{{ $productVariant->product->is_active }}</td>
                                                <td>{{ $productVariant->price  }}</td>
                                                <td>{{ $productVariant->discount_price }}</td>
                                                <td>{{ $productVariant->currency }}</td>
                                                <td>{{ $productVariant->stock}}</td>
                                                <td>{{ $productVariant->product->options->pluck('name')->implode(',') ?? null }}</td>
                                                <td>{{ $productVariant->optionValues->pluck('value')->implode(',') ?? null }}</td>
                                                <td>{{ $productVariant->product->created_at }}</td>
                                                <td>{{ $productVariant->product->updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $productVariant->product->id) }}" style="color: blue; padding: 20px;">Edit</a>
                                                    <form method="POST" action="{{ route('admin.products.destroy', $productVariant->product->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn" style="color: red">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <div>
                {{ $productVariants->links() }}
            </div>

            @include('sbadmin2.components.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
