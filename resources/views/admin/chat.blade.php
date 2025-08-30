@extends('layouts.admin')

@section('content')
<div class="chat-dashboard">
    <div class="user-list">
        <h3>Active Chats</h3>
        <ul id="active-users">
            </ul>
    </div>
    <div class="chat-area">
        <h3 id="chat-with">Select a chat</h3>
        <div id="admin-chat-messages"></div>
        <form id="admin-chat-form" class="hidden">
            <input type="hidden" id="admin-chat-user-id">
            <input type="text" id="admin-chat-input" placeholder="Type your reply...">
            <button type="submit">Send</button>
        </form>
    </div>
</div>
@endsection