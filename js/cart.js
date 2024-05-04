// cart.js

// Function to add item to cart
function addToCart(itemName, price, quantity) {
  // Retrieve cart items from local storage
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  
  // Check if the item is already in the cart
  let found = cart.find(item => item.name === itemName);
  
  if (found) {
      // If item exists, update quantity
      found.quantity += quantity;
  } else {
      // If item doesn't exist, add it to the cart
      cart.push({ name: itemName, price: price, quantity: quantity });
  }
  
  // Save cart back to local storage
  localStorage.setItem('cart', JSON.stringify(cart));
  
  // Update cart display
  updateCartDisplay();
}

// Function to update cart display
function updateCartDisplay() {
  // Retrieve cart items from local storage
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  
  // Display cart items in HTML
  let cartElement = document.getElementById('cart');
  cartElement.innerHTML = '';
  
  cart.forEach(item => {
      let itemHTML = `
          <div class="cart-item">
              <span>${item.name}</span>
              <span>Price: $${item.price}</span>
              <span>Quantity: ${item.quantity}</span>
              <span>Total: $${item.price * item.quantity}</span>
          </div>
      `;
      cartElement.innerHTML += itemHTML;
  });
}

// Event listener for "Add to Cart" buttons
document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', () => {
      let itemName = button.dataset.name;
      let itemPrice = button.dataset.price;
      let itemQuantity = parseInt(button.previousElementSibling.querySelector('.quantity').value);
      addToCart(itemName, itemPrice, itemQuantity);
  });
});

// Initial update of cart display
updateCartDisplay();


document.addEventListener('DOMContentLoaded', function() {
  // Event listener for plus and minus buttons
  document.querySelectorAll('.quantity-btn').forEach(button => {
      button.addEventListener('click', () => {
          let inputField = button.parentElement.querySelector('.quantity');
          let currentValue = parseInt(inputField.value);
          if (button.classList.contains('plus-btn')) {
              inputField.value = currentValue + 1;
          } else if (button.classList.contains('minus-btn') && currentValue > 1) {
              inputField.value = currentValue - 1;
          }
      });
  });
});

// Example function to update cart item count
function updateCartItemCount(count) {
    document.getElementById("cartItemCount").innerText = count;
  }
  
  // Example usage: update cart item count to 5
  updateCartItemCount(5);
  