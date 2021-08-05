@extends('master', ['slug' => "Clients", 'page_title' => "Edit Client"])
@section('content')

    <!-- Displays FormBuilder from Controller -->
    {!! $form_html !!}





    <!-- Displays Validation Errors -->
    @if ($errors->any())
        <div class='col-xs-4 col-xs-offset-1 ccf_form_container'>
            <h3 id='ccf_form_error_title'>Error changing record</h3>
            <ul id="ccf_form_error_ul">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
