
const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);

function payWithPaystack(e) {
  e.preventDefault();

  let handler = PaystackPop.setup({
    key: 'pk_test_803a9504c55c0845a3208ceb5d1cd735936c92b8', // Replace with your public key
    email: document.getElementById("email-address").value,
    amount:  document.getElementById("amount").value * 100,
    currency: 'NGN',
    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    // label: "Optional string that replaces customer email"
    onClose: function(){
      alert('Window closed.');
    },
    callback: function(response){
      const message = response.reference;
      window.location.href="pay.php?sucessfullpaid="+ message;
      
    }
  });

  handler.openIframe();
  
}


