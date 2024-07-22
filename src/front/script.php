<script>
    function limitLength(chars,feedbackElementId){
        const element = event.target;
        const feedbackElement = document.querySelector(`#${feedbackElementId}`);
        feedbackElement.textContent = element.value ? 100 - element.value.length : 100 ;
        feedbackElement.style.color = parseInt(feedbackElement.textContent) > 0 ? "black" : "red";
        //console.log(`${element.name} length: ${element.value.length}`);
    }
    function updateImageOnChange(fileInputId,fileDisplayElementId) {

        var fileInput = document.getElementById(fileInputId);
        var fileDisplayArea = document.getElementById(fileDisplayElementId);


        fileInput.addEventListener('change', function(e) {
            var file = fileInput.files[0];
            var imageType = /image.*/;

            if (file.type.match(imageType)) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    fileDisplayArea.src = reader.result;
                }

                reader.readAsDataURL(file); 
            } else {
                fileDisplayArea.innerHTML = "File not supported!"
            }
        });
    }
</script>