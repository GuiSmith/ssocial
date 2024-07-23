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

    let selectedFiles = []; // Array to keep track of selected files

    function updateMultipleImagesOnChange(filesInputId, filesDisplayElementId) {
        var filesInput = document.getElementById(filesInputId);
        var filesDisplayArea = document.getElementById(filesDisplayElementId);

        filesInput.addEventListener('change', (e) => {
            var files = Array.from(filesInput.files);
            files.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file); // Add new file to the selectedFiles array
                }
            });
            renderImages();
        });

        function renderImages() {
            filesDisplayArea.innerHTML = ""; // Clear existing images
            selectedFiles.forEach(file => {
                if (file.type.match(/image.*/)) {
                    var reader = new FileReader();

                    reader.onload = (e) => {
                        let captionInput = document.createElement('input');
                        captionInput.name = 'caption[]';
                        captionInput.className = "form-control";
                        captionInput.maxLength = 100;
                        captionInput.placeholder = "Digite uma legenda para esta imagem...";

                        let deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'btn btn-danger btn-sm';
                        deleteButton.innerHTML = 'Delete';
                        deleteButton.onclick = function() {
                            if (confirm("Tem certeza de que deseja deletar esta imagem da postagem?")) {
                                selectedFiles = selectedFiles.filter(f => f.name !== file.name || f.size !== file.size); // Remove file from selectedFiles
                                filesDisplayArea.removeChild(div);
                                renderImages(); // Re-render images
                            }
                        };

                        let img = new Image();
                        img.src = reader.result;
                        img.className = "post-img rounded mx-auto d-block p-1";

                        let div = document.createElement('div');
                        div.className = "form-group img-thumbnail";
                        div.appendChild(captionInput);
                        div.appendChild(img);
                        div.appendChild(deleteButton);
                        filesDisplayArea.appendChild(div);
                    }

                    reader.readAsDataURL(file);
                }
            });
            filesDisplayArea.style.display = "block";
        }
    }
</script>