function addCart(id) {
let toastBox = document.getElementById('toastBox')
url = Routing.generate('app_add_cart', { id: id})
console.log(url)
    $.post( url, function() {
        let toast = document.createElement('div');
        toast.classList.add('customToast');
        toast.innerHTML = '<i class="fa-solid fa-circle-check"></i> produit ajouté avec success';
        toastBox.appendChild(toast);
    
        setTimeout(()=> {
            toast.remove()
        }, 3500)
      });
    }





