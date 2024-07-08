<script>
    function limitLength(chars,feedbackElementId){
        const element = event.target;
        const feedbackElement = document.querySelector(`#${feedbackElementId}`);
        feedbackElement.textContent = element.value ? 100 - element.value.length : 100 ;
        feedbackElement.style.color = parseInt(feedbackElement.textContent) > 0 ? "black" : "red";
        //console.log(`${element.name} length: ${element.value.length}`);
    }
</script>