@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Product Page</h4><br>

            <form method="post" action="{{ route('product.store')}}" id="myForm">
                @csrf

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                    <div class="col-sm-10 form-group">
                        <input name="name" class="form-control" type="text" >
                    </div>
                </div>
                <!-- end row -->

                <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Name</label>
                <div class="col-sm-10 form-group">
                <select name="supplier_id" class="form-select" aria-label="Default select example">
                    <option selected="">Open this select menu</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
                <div class="col-sm-10 form-group">
                <select name="category_id" class="form-select" aria-label="Default select example">
                    <option selected="">Open this select menu</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Unit Name</label>
                <div class="col-sm-10 form-group">
                <select name="unit_id" class="form-select" aria-label="Default select example">
                    <option selected="">Open this select menu</option>
                    @foreach($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <!-- end row -->

                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Product">
            </form>
        </div>
    </div>
</div> <!-- end col -->




</div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
                unit_id: {
                    required : true,
                },
                supplier_id: {
                    required : true,
                },
                category_id: {
                    required : true,
                },  
            },
            messages :{
                name: {
                    required : 'Please Enter Product Name',
                },
                unit_id: {
                    required : 'Please Enter Unit',
                },
                supplier_id: {
                    required : 'Please Enter Supplier',
                },
                category_id: {
                    required : 'Please Enter Category',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>

@endsection 