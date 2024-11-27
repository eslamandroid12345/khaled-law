@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.chat'))
@section('css_addons')
    <style>
        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f0f2f5;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .chat-box {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .chat-message {
            display: flex;
            flex-direction: column;
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            color: #fff;
            word-wrap: break-word;
        }

        .chat-message.sent {
            align-self: flex-end;
            background: #7f7f7f;
            border-top-right-radius: 0;
        }

        .chat-message.received {
            align-self: flex-start;
            background: #343a40;
            border-top-left-radius: 0;
        }

        .chat-content {
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 8px;
            margin-bottom: 5px;
        }

        .chat-user {
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            margin-right: auto; /* Pushes the username to the left */
        }

        .chat-time {
            font-size: 12px;
            color: #ddd;
        }

        .chat-empty {
            text-align: center;
            color: #999;
        }
        .chat-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px; /* Size of the avatar container */
            height: 30px;
            border-radius: 50%;
            overflow: hidden; /* Ensures image fits within rounded container */
            background-color: #ddd; /* Default background for fallback icons */
        }

        .avatar-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures image covers the area without distortion */
            border-radius: 50%; /* Ensures the image remains circular */
        }

        .avatar-icon {
            font-size: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        .chat-text {
            padding: 10px;
            margin-top: 5px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.1); /* Subtle background for chat messages */
            word-wrap: break-word;
            max-width: 100%;
        }

        .chat-text p {
            margin: 0;
            color: #fff; /* Text color */
        }

        .chat-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 5px;
            cursor: pointer; /* Optional: pointer cursor for images */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: adds a shadow */
        }

        .chat-audio {
            width: 100%;
            border-radius: 8px;
            margin-top: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Adds a shadow to audio elements */
        }

        .chat-file {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-top: 5px;
            background-color: #343a40; /* Dark background for file links */
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Adds a shadow to file links */
        }

        .chat-file i {
            margin-right: 8px; /* Space between icon and text */
            font-size: 16px;
        }

    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.chat')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="chat-container">
                        <div class="chat-box">
                            @forelse($messages as $message)
                                <div class="chat-message {{ $message->user?->type === 'LAWYER' ? 'sent' : 'received' }}">
                                    <div class="chat-content">
                                        <div class="chat-header">
                        <span class="chat-time">
                            <i class="fas fa-clock"></i> {{ $message->created_at->format('H:i') }}
                        </span>
                                            <a href="{{ route('users.show', $message->user?->id) }}" class="chat-user">
                                                {{ $message->user?->name }}
                                            </a>
                                            <div class="chat-avatar">
                                                @isset($message->user?->image)
                                                    <img src="{{ asset($message->user?->image) }}" alt="{{ $message->user?->name }}" class="avatar-image">
                                                @else
                                                    <i class="fas fa-user {{ $message->user?->type === 'LAWYER' ? 'bg-green' : 'bg-red' }} avatar-icon"></i>
                                                @endisset
                                            </div>

                                        </div>
                                        <div class="chat-text">
                                            @if($message->type == 'TEXT')
                                                <!-- Render text message -->
                                                <p>{{ $message->content }}</p>

                                            @elseif($message->type == 'IMAGE')
                                                <!-- Render image message -->
                                                <img src="{{ asset($message->content) }}" alt="Image message" class="chat-image">

                                            @elseif($message->type == 'AUDIO')
                                                <!-- Render audio message -->
                                                <audio controls class="chat-audio">
                                                    <source src="{{ asset($message->content) }}" type="audio/mpeg"> <!-- Adjust type if a different audio format -->
                                                    Your browser does not support the audio element.
                                                </audio>

                                            @elseif($message->type == 'FILE')
                                                <!-- Render file download link -->
                                                <a href="{{ asset($message->content) }}" class="chat-file" download>
                                                    <i class="fas fa-file-alt"></i> Download file
                                                </a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <p class="chat-empty">The chat is empty</p>
                            @endforelse
                        </div>
                    </div>


                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('js_addons')

@endsection
