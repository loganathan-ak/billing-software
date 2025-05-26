    <!--sidenav -->
    <div class="fixed left-0 top-0 w-64 h-full bg-[#062242] p-4 z-50 sidebar-menu transition-transform">
        <a href="/" class="flex items-center ps-2.5 mb-5">
            <img src="{{ asset('carava.png') }}" class="w-3/4" alt="Logo" />
        </a>
        <ul class="space-y-2 font-medium mt-5">
            <li>
               <a href="/" class="flex items-center p-2  rounded-lg text-white hover:bg-gray-100 hover:text-[#062242]  group">
                  <svg class="w-4 h-4 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                     <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                  </svg>
                  <span class="ms-3 text-sm">Dashboard</span>
               </a>
            </li>
            <li>
               <a href="/items" class="flex items-center p-2  rounded-lg text-white hover:bg-gray-100  hover:text-[#062242] group">
                  <svg class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5v14m8-7h-2m0 0h-2m2 0v2m0-2v-2M3 11h6m-6 4h6m11 4H4c-.55228 0-1-.4477-1-1V6c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v12c0 .5523-.4477 1-1 1Z"/>
                    </svg>
                    
                  <span class="flex-1 ms-3 text-sm whitespace-nowrap">Items</span>
               </a>
            </li>
            <li>
               <a href="/vendors" class="flex items-center p-2  rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                  <svg class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z"/>
                  </svg>
                    
                  <span class="flex-1 ms-3 text-sm whitespace-nowrap">Vendor</span>
               </a>
            </li>
            <li>
               <a href="/customers" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                  <svg class="w-4 h-4 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                     <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                  </svg>
                  <span class="flex-1 ms-3 text-sm whitespace-nowrap">Customer</span>
               </a>
            </li>
            <li>
               <a href="/sales-invoice" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                  <svg class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z"/>
                  </svg>
                    
                  <span class="flex-1 ms-3 text-sm whitespace-nowrap">Sales</span>
               </a>
            </li>
            <li>
                <a href="/b2b-invoice" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                   <svg class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z"/>
                   </svg>
                     
                   <span class="flex-1 ms-3 text-sm whitespace-nowrap">B 2 B</span>
                </a>
             </li>
            <li>
               <a href="/purchases" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                  <svg class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4"/>
                    </svg>
                    
                  <span class="flex-1 ms-3 text-sm whitespace-nowrap">Purchase</span>
               </a>
            </li>
            <li>
               <a href="/expenses" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                  <svg class="w-4 h-4 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                     <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                     <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                     <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                  </svg>
                  <span class="flex-1 ms-3 text-sm whitespace-nowrap">Expense</span>
               </a>
            </li>
            <li>
                <a href="{{route('chits')}}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                   <svg class="w-4 h-4 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                      <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                      <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                   </svg>
                   <span class="flex-1 ms-3 text-sm whitespace-nowrap">Chits</span>
                </a>
             </li>
            <li>
                <a href="/reports" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                    <svg class="w-4 h-4 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v15a1 1 0 0 0 1 1h15M8 16l2.5-5.5 3 3L17.273 7 20 9.667"/>
                      </svg>
                      
                   <span class="flex-1 ms-3 text-sm whitespace-nowrap">Report</span>
                </a>
             </li>
             @if( Auth::user()->user_role === 'admin' )
             <li>
                <a href="/employees" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-100 hover:text-[#062242] group">
                      <svg class="w-4 h-4 text-white transition duration-75 dark:text-gray-400 group-hover:text-[#062242]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                      </svg>
                      
                      
                   <span class="flex-1 ms-3 text-sm whitespace-nowrap">Employees</span>
                </a>
             </li>
             @endif
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- end sidenav -->

    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-200 min-h-screen transition-all main">
        <!-- navbar -->
        <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
            <button type="button" class="text-lg text-gray-900 font-semibold sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="ml-auto flex items-center">
                <li class="dropdown ml-3">
                    <button type="button" class="dropdown-toggle flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 relative">
                            <div class="p-1 bg-white rounded-full focus:outline-none focus:ring">
                                <img class="w-8 h-8 rounded-full" src="https://laravelui.spruko.com/tailwind/ynex/build/assets/images/faces/9.jpg" alt=""/>
                                <div class="top-0 left-7 absolute w-3 h-3 bg-lime-400 border-2 border-white rounded-full animate-ping"></div>
                                <div class="top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full"></div>
                            </div>
                        </div>
                        <div class="p-2 md:block text-left">
                            <h2 class="text-sm font-semibold text-gray-800">{{Auth::user()->name}}</h2>
                            <p class="text-xs text-gray-500">{{$email = Auth::user()->email;}}</p>
                        </div>                
                    </button>
                    <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        @if(Auth::user()->user_role === 'admin')
                        <li>
                            <a href="{{route('userprofile')}}" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50 cursor-pointer">Profile</a>
                        </li>
                        @endif
                        <li>
                            <form method="POST" action="{{route('logout')}}">
                                @csrf
                                <button type="submit" role="menuitem" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50 cursor-pointer">
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- end navbar -->

      <!-- Content -->
        {{$slot}}
      <!-- End Content -->
    </main>


