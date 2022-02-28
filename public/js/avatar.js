function previewProfileImage(uploader) {
  //ensure a file was selected
  if (uploader.files && uploader.files[0]) {
    var imageFile = uploader.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
      //set the image data as source
      $(".avatar").attr("src", e.target.result);
    };
    reader.readAsDataURL(imageFile);
  }
}
$("#change-avatar").change(function () {
  previewProfileImage(this);
});
