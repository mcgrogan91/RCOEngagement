@extends('layouts/main')
@section('header')
@endsection
@section('content')
    <div class="container">
        @if (\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="text-center"><strong>Registered Community Organization Survey</strong></div><br/>
        <form name="survey" method="POST">
            {{csrf_field()}}
            <div class="form-group row">
                <label for="name" class="col-2 col-form-label">Organization Name</label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{$rco->name}}" id="name" disabled>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <label for="mission_statement" class="col-2 col-form-label">Abbreviated Mission Statement</label>
                <div class="col-10">
                    <textarea class="form-control" id="mission_statement" name="mission_statement" rows="7" maxlength="2000"{{$token->used ? ' disabled': ''}}>{{$rco->mission_statement}}</textarea>
                    <h6 class="pull-right" id="count_message"></h6>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <label for="social_media" class="col-2 col-form-label">Social Media</label>
                <div class="col-10">
                    Website: <input
                                class="form-control"
                                type="text"
                                value="{{$rco->getMedia('Website') ? $rco->getMedia('Website')->handle : ''}}"
                                name="social_media[website]"
                                {{$token->used ? ' disabled': ''}}>
                    Instagram: <input
                                class="form-control"
                                type="text"
                                value="{{$rco->getMedia('Instagram') ? $rco->getMedia('Instagram')->handle : ''}}"
                                name="social_media[instagram]"
                                {{$token->used ? ' disabled': ''}}>
                    Twitter: <input
                                class="form-control"
                                type="text"
                                value="{{$rco->getMedia('Twitter') ? $rco->getMedia('Twitter')->handle : ''}}"
                                name="social_media[twitter]"
                                {{$token->used ? ' disabled': ''}}>
                    Facebook: <input
                                class="form-control"
                                type="text"
                                value="{{$rco->getMedia('Facebook') ? $rco->getMedia('Facebook')->handle : ''}}"
                                name="social_media[facebook]"
                                {{$token->used ? ' disabled': ''}}>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <label for="committees" class="col-2 col-form-label">Committees<br/>(Up to 10)</label>
                <div class="col-10">
                    <ol id="committee_list">
                    @foreach($rco->committees as $committee)
                        <li class="form-group row">
                            <input class="form-control col-sm-11" type="text" value="{{$committee->name}}" name="committees[]"{{$token->used ? ' disabled': ''}}>
                            @if(!$token->used)
                                <button class="remove-committee col-sm-1 btn btn-sm btn-outline-danger">Remove</button>
                            @endif
                        </li>
                    @endforeach
                    </ol>
                    @if(!$token->used && count($rco->committees) < 10)
                        <button id="add_committee" class="btn btn-md btn-outline-success">Add Committee</button>
                    @endif

                </div>
            </div>

            @if(!$token->used)
                <button class="btn btn-success">Submit</button>
            @endif
        </form>
    </div>
@endsection

@section('footer')
@endsection

@section('script')
    @if(!$token->used)
        <script type="text/javascript">
            var difference = function(input, message, max_length) {
                var text_length = input.val().length;
                var remaining = max_length - text_length;

                message.html(remaining + ' characters remaining');
            }

            var mission_statement = $('#mission_statement');
            var mission_message = $('#count_message');
            var mission_maximum = 2000;

            difference(mission_statement, mission_message, mission_maximum);
            mission_statement.on('keyup', function() {
                difference(mission_statement, mission_message, mission_maximum);
            });

            var list = $("#committee_list");

            $("#add_committee").on('click', function() {
                var list = $("#committee_list");
                if (list.children().length < 10) {
                    list.append('<li class="form-group row">'
                            +'<input class="form-control col-sm-11" type="text" value="" name="committees[]">'
                            +'<button class="remove-committee col-sm-1 btn search btn-sm btn-outline-danger">Remove</button>'
                            +'</li>');
                }

                if (list.children().length >= 10) {
                    $("#add_committee").hide();
                }
                return false;
            });

            $('ol').on('click', '.remove-committee', function(event, el) {
                $(this).parent().remove();
                if (list.children().length < 10) {
                    $("#add_committee").show();
                }
            })
        </script>
    @endif
@endsection