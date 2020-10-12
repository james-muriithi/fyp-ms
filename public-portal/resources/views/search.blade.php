@extends('layouts.app')
@section('content')
    <div class="">
        <div id="header">
            <div id="topbar">
                <img id="searchbarimage" src="{{asset('images/logo.png')}}" />
                <form method="GET" action="{{route('search')}}" >
                    <div id="searchbar" type="text">
                        <input id="searchbartext" type="text" name="q" value="{{$query ?? ''}}" />
                        <button id="searchbarbutton">
                            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>

                <a href="#">
                    <img id="profileimage"  src="{{asset('images/avatar.png')}}" />
                </a>
            </div>
            <div id="optionsbar">
                <ul id="optionsmenu1">
                    <li id="optionsmenuactive">All</li>
                </ul>

            </div>
        </div>
        <div id="searchresultsarea">
            <p id="searchresultsnumber" class="mt-1">{{isset($projects) ? $projects->total() : 0}} projects </p>

            @if(count($projects) > 0)
                @foreach($projects as $project)
                    <div class="searchresult">
                        <a href="#" data-toggle="modal" data-target="#modal-{{$project->id}}">
                            <h2>{{$project->title}} - {{$project->projectCategory->name}}</h2>
                        </a>
                        <a>Supervisor: {{ucwords($project->lecturer->full_name)}} </a>
                        <p>{{$project->description}}</p>
                        <p class="row">
                            <span class="col-6">
                                Finish Date: {{strftime('%m/%d/%Y', strtotime($project->complete_date))}}
                            </span>
                            <span class="col-6">
                                Student: {{ucwords($project->projectStudent->full_name)}}
                            </span>
                        </p>
                    </div>

                    <div class="modal" id="modal-{{$project->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title text-bold">{{$project->title}}</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <table class="table table-borderless">
                                        @foreach($project->uploads as $upload)
                                            @php($uploadDir = str_replace('/','', $project->projectStudent->reg_no).'/'.$upload->category.'/')
                                            @php($file = '../student/uploads/'.$uploadDir.$upload->name)
                                            @php($ext = pathinfo($file, PATHINFO_EXTENSION))
                                            <tr>
                                                <td>{{$upload->uploadCategory->name}}</td>
                                                <td>
                                                    @if($ext == 'pdf')
                                                        <i class="fa fa-file-pdf-o text-danger"></i> PDF File
                                                    @elseif($ext == 'doc' || $ext == 'docx')
                                                        <i class="fa fa-file-word-o text-danger"></i> Word File
                                                    @elseif($ext == 'zip' || $ext == 'rar')
                                                        <i class="fa fa-file-zip-o text-danger"></i> Zip File
                                                    @else
                                                        <i class="fa fa-file-o text-danger"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{$file}}" class="btn btn-sm btn-success" download>
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach
            @endif

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{$projects->links("pagination::bootstrap-4")}}
                </div>
            </div>
        </div>

    </div>
@endsection
