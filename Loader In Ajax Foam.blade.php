********************** Implement A Loader When Submit Foam Through Ajax ********************************************




********************* Add Loader Css ***********************

<style>
.loader {
  --d:22px;
  width: 4px;
  height: 4px;
  border-radius: 50%;
  color: #25b09b;
  box-shadow: 
    calc(1*var(--d))      calc(0*var(--d))     0 0,
    calc(0.707*var(--d))  calc(0.707*var(--d)) 0 1px,
    calc(0*var(--d))      calc(1*var(--d))     0 2px,
    calc(-0.707*var(--d)) calc(0.707*var(--d)) 0 3px,
    calc(-1*var(--d))     calc(0*var(--d))     0 4px,
    calc(-0.707*var(--d)) calc(-0.707*var(--d))0 5px,
    calc(0*var(--d))      calc(-1*var(--d))    0 6px;
  animation: l27 1s infinite steps(8);
}
@keyframes l27 {
  100% {transform: rotate(1turn)}
} 
</style>



********************* Add Loader Class In The Foam  ***********************

<span class="loader" id="loader" style="display: block;	position: fixed;	top: 50%; left: 58%;"></span>



********************* Add Script According To You  ***********************

<script>
	hideLoader();
    // Function to show loader
    function showLoader() {
        document.getElementById('loader').style.display = 'block';
    }

    // Function to hide loader
    function hideLoader() {
		// alert("kjhgjkhjkh");
        document.getElementById('loader').style.display = 'none';
    }

    // Add event listener to the form for form submission
    document.getElementById('transactionForm').addEventListener('submit', function () {
      // Show loader when form is submitted
	  showLoader();
    });

 
</script>