
<div class="container mx-auto">
  <div class="flex flex-row grid grid-cols-4 gap-1">
     <div class="form-group">
        <label for="notification_email">Bg Colour <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar" value="{{ $settings->bg_sidebar }}" required>
    </div>
    <div class="form-group">
        <label for="notification_email">Bg sidebar Hover <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_hover" value="{{ $settings->bg_sidebar_hover }}" required>
    </div>
  <div class="form-group">
        <label for="notification_email">Bg Sidebar Aktif <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_aktif" value="{{ $settings->bg_sidebar_aktif }}" required>
    </div>

<div class="form-group">
        <label for="notification_email">Bg Sidebar Link <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_link" value="{{ $settings->bg_sidebar_link }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Bg Sidebar Link hover <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_link_hover" value="{{ $settings->bg_sidebar_link_hover }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Link Color <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="link_color" value="{{ $settings->link_color }}" required>
    </div>
<div class="form-group">
        <label for="notification_email">Link hover <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="link_hover" value="{{ $settings->link_hover }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Header bg <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="header_color" value="{{ $settings->header_color }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Btn Color<span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="btn_color" value="{{ $settings->btn_color }}" required>
    </div>

    <div class="form-group">
        <label for="notification_email">Btn Cancel<span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="btn_color" value="{{ $settings->btn_cancel }}" required>
    </div>

    <div class="form-group">
        <label for="notification_email">Btn Success<span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="btn_color" value="{{ $settings->btn_sukses }}" required>
    </div>




  </div>
</div>