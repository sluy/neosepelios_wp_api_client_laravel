<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
        <x-livewire-alert::scripts />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="h-full overflow-hidden">
        <div class="h-full flex">
            <!-- Static sidebar for desktop -->
            <div class="hidden lg:flex lg:flex-shrink-0">
              <div class="flex flex-col w-64">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-gray-100">
                  <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center justify-center flex-shrink-0 px-4">
                      <img class="h-8 w-auto" src="{{asset('images/logo-dark.png')}}" alt="WhatsAPI">
                    </div>
                    <nav class="mt-5 flex-1" aria-label="Sidebar">
                      <div class="px-2 space-y-1">
                        <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                        <a href="{{route('dashboard')}}" class="
                            @if(Route::is('dashboard'))
                                bg-gray-200 text-gray-900
                            @else
                                text-gray-600 hover:bg-gray-50 hover:text-gray-900
                            @endif
                                group flex items-center px-2 py-2 text-sm font-medium rounded-md
                        ">
                          Dashboard
                        </a>

                        @foreach(Auth::user()->instances as $instance)
          
                        <a href="{{route('instance', $instance)}}" class="
                            @if(url()->current() == route('instance', ['id' => $instance->id]))
                                bg-gray-200 text-gray-900
                            @else
                                text-gray-600 hover:bg-gray-50 hover:text-gray-900
                            @endif
                              hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                          {{$instance->name}}
                        </a>

                        @endforeach

                        <div class="flex justify-center pt-8">
                            <a href="{{route('createInstance')}}" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <!-- Heroicon name: solid/plus -->
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                                Create Instance
                            </a>
                        </div>
          
                      </div>
                    </nav>
                  </div>
                  <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <a href="#" class="flex-shrink-0 w-full group block">
                      <div class="flex items-center">
                        <div>
                          <img class="inline-block h-9 w-9 rounded-full" src="https://ui-avatars.com/api/?name={{Auth::user()->name}}" alt="">
                        </div>
                        <div class="ml-3">
                          <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{Auth::user()->name}}</p>
                          <p
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-xs font-medium text-gray-500 group-hover:text-gray-700">Logout</p>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
              <div class="flex-1 relative z-0 flex overflow-hidden">
                @yield('content')
              </div>
            </div>
          </div>
          @stack('scripts')
    </body>
</html>
