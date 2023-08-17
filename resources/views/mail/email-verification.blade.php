<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Davez Delivery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/tailwindcss@0.7.4/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet" />
</head>
<body>
    <div class="app font-sans min-w-screen min-h-screen bg-grey-lighter py-8 px-4">

        <div class="mail__wrapper max-w-md mx-auto">
      
          <div class="mail__content bg-white p-8 shadow-md">
      
            <div class="content__header text-center tracking-wide border-b">
              <div class="text-red text-sm font-bold">DavezDelivery.com</div>
              <h1 class="text-xl lg:text-3xl h-48 flex items-center justify-center">{{ $details["title"] }}</h1>
            </div>
      
            <div class="content__body py-8 border-b">
              <p>
                Hey, {{$details["name"]}}<br><br> {{ $details["body"]}}
              </p>
              <button class="text-white text-sm tracking-wide bg-red rounded-full w-full my-8 p-4 "> {{$details["code"]}} </button>
            </div>
      
            <div class="content__footer mt-8 text-center text-grey-darker">
              <h3 class="text-base sm:text-lg mb-4">Thanks for using The App!</h3>
              <p>www.davezdelivery.com</p>
            </div>
      
          </div>
      
          <div class="mail__meta text-center text-sm text-grey-darker mt-8">
      
            <div class="meta__social flex justify-center my-4">
              <a href="#" class="flex items-center justify-center mr-4 bg-black text-white rounded-full w-8 h-8 no-underline"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="flex items-center justify-center mr-4 bg-black text-white rounded-full w-8 h-8 no-underline"><i class="fab fa-instagram"></i></a>
              <a href="#" class="flex items-center justify-center bg-black text-white rounded-full w-8 h-8 no-underline"><i class="fab fa-twitter"></i></a>
            </div>
{{--       
            <div class="meta__help">
              <p class="leading-loose">
                Questions or concerns? <a href="#" class="text-grey-darkest">help@theapp.io</a>
      
                <br> Want to quit getting updates? <a href="#" class="text-grey-darkest">Unsubscribe</a>
              </p>
            </div> --}}
      
          </div>
      
        </div>
      
      </div>
</body>
</html>