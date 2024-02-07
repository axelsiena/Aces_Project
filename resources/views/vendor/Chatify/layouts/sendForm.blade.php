<div class="messenger-sendCard border">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" class="gap-2" enctype="multipart/form-data">
        @csrf
        <label><span class="fas fa-plus-circle text-primary"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
        <button class="emoji-button"></span><span class="fas fa-smile text-primary"></button>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane text-primary"></span></button>
    </form>
</div>
