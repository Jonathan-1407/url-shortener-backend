@extends('layout.app')

@section('content')
  <nav
    class="z-50 w-full bg-white top-0 flex flex-wrap items-center justify-between py-3 navbar-expand-lg shadow">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
      <div class="w-full flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
        <a
          class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-gray-800"
          href="/">
          Free Shortener URL
        </a>
      </div>
      <div class="lg:flex flex-grow items-center">
        <ul class="flex lg:flex-row list-none lg:ml-auto justify-center">
          <li class="nav-item">
            <a
              class="px-3 py-2 flex items-center text-xs uppercase font-bold text-gray-800 hover:text-gray-600"
              href="#">
              <span class="ml-2">Create Account</span>
            </a>
          </li>
          <li class="nav-item">
            <a
              href="#"
              class="rounded-full bg-indigo-600 text-white active:bg-indigo-600 text-xs font-bold uppercase px-4 py-3 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-2"
              style="transition: all 0.15s ease 0s;"
            >
              Login <i class="fas fa-arrow-right"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <section class="pb-20 py-10 relative bg-gray-100">
    <div class=" top-0 bottom-auto left-0 right-0 w-full absolute"
         style="height: 80px; transform: translateZ(0px);">
        <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
             preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-gray-100 fill-current" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
    <div class="justify-center text-center flex flex-wrap py-8">
        <div class="w-full md:w-6/12 px-12 md:px-4"><h2 class="font-semibold text-4xl">Shortener URL</h2>
            <p class="text-lg leading-relaxed mt-4 mb-4 text-gray-600">
              Lorem asperiores placeat sed ab ipsa! Quasi nam commodi natus officia nesciunt.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="items-center flex flex-col md:flex-row">
            <div class="w-full md:w-4/12 mr-auto px-4 md:pt-0 my-0">
                <lottie-player
                        src="https://assets3.lottiefiles.com/packages/lf20_vrtIsn.json" background="transparent" speed="1"
                        style="width: 100%; height: 100%;" loop autoplay>
                </lottie-player>
            </div>
            <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
                <div class="md:pr-4">
                    <div
                            class="text-indigo-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white"
                    >
                        <i class="fas fa-rocket text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-semibold">Speed Service</h3>
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                      Elit error blanditiis labore odit maxime Natus eveniet facilis ad aliquid iure.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="items-center flex flex-col md:flex-row-reverse">
            <div class="w-full md:w-4/12 mr-auto px-4 md:pt-0 my-0">
                <lottie-player
                        src="https://assets2.lottiefiles.com/packages/lf20_ZXBZ0q.json" background="transparent" speed="1"
                        style="width: 100%; height: 100%;" loop autoplay>
                </lottie-player>
            </div>
            <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
                <div class="md:pr-4">
                    <div
                            class="text-indigo-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white"
                    >
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-semibold">Increased Productivity</h3>
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                      Amet aperiam ullam nam explicabo non Assumenda 
                      nobis enim eveniet nostrum voluptatem! 
                      Vel ipsam explicabo sint harum corporis?
                      Minima similique omnis odit odio facilis sit.                    
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="items-center flex flex-col md:flex-row">
            <div class="w-full md:w-4/12 mr-auto px-4 md:pt-0 my-0">
                <lottie-player
                        src="https://assets5.lottiefiles.com/datafiles/Nggyholrjfk0tbh/data.json" background="transparent"
                        speed="1"
                        style="width: 100%; height: 100%;" loop autoplay>
                </lottie-player>
            </div>
            <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
                <div class="md:pr-4">
                    <div
                            class="text-indigo-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white"
                    >
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-semibold">Completely Free</h3>
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                      Consectetur in dignissimos recusandae ab repudiandae perferendis 
                      Fugit placeat commodi numquam accusantium voluptates? Eum recusandae 
                      animi ut ratione explicabo.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
  </main>
  <footer class="relative bg-gray-100">
    <div class="container mx-auto px-4">
        <hr class="my-6 border-gray-400">
        <div class="flex flex-wrap items-center md:justify-between justify-center">
            <div class="w-full md:w-4/12 mx-auto text-center">
                <div class="text-sm text-gray-600 font-semibold py-1 pb-5">
                    Copyright © {{date('Y')}} Jonathan Cua
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
