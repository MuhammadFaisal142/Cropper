<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Image Editor in JavaScript | CodingNepal</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css" integrity="sha512-C4k/QrN4udgZnXStNFS5osxdhVECWyhMsK1pnlk+LkC7yJGCqoYxW4mH3/ZXLweODyzolwdWSqmmadudSHMRLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js" integrity="sha512-LjPH94gotDTvKhoxqvR5xR2Nur8vO5RKelQmG52jlZo7SwI5WLYwDInPn1n8H9tR0zYqTqfNxWszUEy93cHHwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<style>  .highlight {
    background-color: #007bff; /* Change this to the desired highlight color */
    color: white; /* Text color */
    border: none;
  }</style>
  </head>
  <body>
  <div class="box hide">
    <input type="file" id="file-input">
  </div>
  <div class="box-2">
    <div class="result">
      <img id="image" src="015.jpg" alt="Dynamic">
    </div>
    <button class="btn show-cropper">Show Cropper</button>
    <!-- Rotate and Flip buttons -->
    <button class="btn rotate-left">Rotate Left</button>
    <button class="btn rotate-right">Rotate Right</button>
    <button class="btn flip-horizontal">Flip Horizontal</button>
    <button class="btn flip-vertical">Flip Vertical</button>
  </div>
  <div class="box-2 img-result hide">
    <img class="cropped" src="" alt="">
  </div>
  <div class="box">
    <div class="options hide">
      <label>Width</label>
      <input type="number" class="img-w" value="300" min="100" max="1200" />
    </div>
    <button class="btn save hide">Save</button>
    <a href="" class="btn download hide" download="imagename.png">Download</a>
  </div>
  <!-- Other script imports -->
  <script>
	// vars
let result = document.querySelector('.result'),
img_result = document.querySelector('.img-result'),
img_w = document.querySelector('.img-w'),
img_h = document.querySelector('.img-h'),
options = document.querySelector('.options'),
save = document.querySelector('.save'),
cropped = document.querySelector('.cropped'),
dwn = document.querySelector('.download'),
upload = document.querySelector('#file-input'),
cropper = '';

// on change show image with crop options
upload.addEventListener('change', (e) => {
  if (e.target.files.length) {
		// start file reader
    const reader = new FileReader();
    reader.onload = (e)=> {
      if(e.target.result){
				// create new image
				let img = document.createElement('img');
				img.id = 'image';
				img.src = e.target.result
				// clean result before
				result.innerHTML = '';
				// append new image
        result.appendChild(img);
				// show save btn and options
				save.classList.remove('hide');
				options.classList.remove('hide');
				// init cropper
				cropper = new Cropper(img);
      }
    };
    reader.readAsDataURL(e.target.files[0]);
  }
});

// save on click
// Add an event listener to the Save button
document.querySelector('.save').addEventListener('click', () => {
    console.log("Save button is clicked");
    if (cropper) {
      // Get cropped image as data URL
      let imgSrc = cropper.getCroppedCanvas({
        width: img_w.value // input value
      }).toDataURL();

      // Display the cropped image in the result container
      cropped.src = imgSrc;
      img_result.classList.remove('hide');
    }
});

// Add an event listener to the button
// Function to add highlight class and remove from other buttons
function highlightButton(button) {
  const buttons = document.querySelectorAll('.btn:not(.show-cropper)');
  buttons.forEach(btn => {
    if (btn === button) {
      btn.classList.add('highlight');
      btn.classList.remove('non-highlight');
    } else {
      btn.classList.remove('highlight');
      btn.classList.add('non-highlight');
    }
  });
}

// Add an event listener to the Crop button
document.querySelector('.show-cropper').addEventListener('click', () => {
    // Show the cropper only if it's active
    if (cropperActive) {
        cropper && cropper.destroy(); // Destroy any previous cropper instance
        cropper = new Cropper(document.getElementById('image'));
        img_result.classList.remove('hide');
        save.classList.remove('hide'); // Show the Save button
    }
});
/// Add an event listener to the Rotate Left button
document.querySelector('.rotate-left').addEventListener('click', () => {
    console.log("Rotate Left button is clicked");
    if (!cropper) {
        cropper = new Cropper(document.getElementById('image'), {
            viewMode: 2, // Set viewMode to 2 for filling the canvas
            aspectRatio: NaN // Disable aspect ratio
        });
    }
    if (cropper) {
        cropper.rotate(-90);
    }
});

// Add an event listener to the Rotate Right button
document.querySelector('.rotate-right').addEventListener('click', () => {
    console.log("Rotate Right button is clicked");
    if (!cropper) {
        cropper = new Cropper(document.getElementById('image'), {
            // Disable aspect ratio
        });
    }
    if (cropper) {
        cropper.rotate(90);
    }
});

// Add an event listener to the Flip Horizontal button
document.querySelector('.flip-horizontal').addEventListener('click', () => {
    console.log("Flip Horizontal button is clicked");
    if (!cropper) {
        cropper = new Cropper(document.getElementById('image'), {
            viewMode: 2, // Set viewMode to 2 for filling the canvas
            aspectRatio: NaN // Disable aspect ratio
        });
    }
    if (cropper) {
        cropper.scaleX(-cropper.getData().scaleX);
    }
});

// Add an event listener to the Flip Vertical button
document.querySelector('.flip-vertical').addEventListener('click', () => {
    console.log("Flip Vertical button is clicked");
    if (!cropper) {
        cropper = new Cropper(document.getElementById('image'), {
            viewMode: 2, // Set viewMode to 2 for filling the canvas
            aspectRatio: NaN // Disable aspect ratio
        });
    }
    if (cropper) {
        cropper.scaleY(-cropper.getData().scaleY);
    }
});


let img = document.getElementById('image'); // Reference to the image element

// Function to rotate the image
// Function to rotate the image
function rotateImage(degrees) {
  img.style.transform = `rotate(${degrees}deg)`;
}

// Function to flip the image
function flipImage(horizontal, vertical) {
  img.style.transform = `scaleX(${horizontal ? -1 : 1}) scaleY(${vertical ? -1 : 1})`;
}


  </script>
</body>
  
</html>