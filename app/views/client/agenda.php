<main class="flex overflow-x-hidden">
    <?php require __DIR__ . '/../includes/nav.php'; ?>
    <div class="lg:w-5/6 w-full flex lg:absolute flex-col justify-start items-start bg-white p-4 pr-6" style="left:17%; top:10%;">

        <h2 class="font-Urbanist font-semibold italic text-4xl text-black w-full border-b border-b-grayInput p-2">Minha agenda</h2>
        <div class="scrolls w-full border-b border-grayInput pb-4 p-4 flex flex-col gap-2">
            <div class="w-full flex items-center gap-12 font-Poppins " id="scrollMonths"></div>
            <div class="w-full flex items-center gap-4  font-Poppins p-2" id="scrollDays"></div>
        </div>

        <ul id="listSchedules" class="schedules w-full p-4">
                <li class="w-full flex flex-col items-start gap-2">
                    <span class="w-full border-b border-grayInput text-grayInput">16:00</span>
                    <div class="schedules w-full flex flex-col gap-4">
                        
                        <span  class="schedule w-full p-4 bg-errorColor rounded-md flex items-center gap-2 mt-2 ml-8">
                            <i class='bx bx-calendar-check text-3xl' style='color:#223249'  ></i>
                            <div class="details flex flex-col">
                                <span class="text-xl font-Urbanist font-semibold">Agendamento</span>
                                <span>13:00 - 17:00</span>
                            </div>
                        </span >

                        <span  class="schedule w-full p-4 bg-errorColor rounded-md flex items-center gap-2 mt-2 ml-8">
                            <i class='bx bx-calendar-check text-3xl' style='color:#223249'  ></i>
                            <div class="details flex flex-col">
                                <span class="text-xl font-Urbanist font-semibold">Agendamento</span>
                                <span>13:00 - 17:00</span>
                            </div>
                        </span >

                    </div>
                    <span class="w-full border-t border-dotted border-grayInput">17:00</span>
                </li>  

                <li class="w-full flex flex-col items-start gap-2">
                    <span class="w-full border-b border-dotted border-grayInput">16:00</span>
                    <span  class="w-full p-4 bg-sucessColor rounded-md flex items-center gap-2 mt-2 ml-8">
                        <i class='bx bx-calendar-check text-3xl' style='color:#223249'  ></i>
                        <div class="details flex flex-col">
                            <span class="text-xl font-Urbanist font-semibold">Agendamento</span>
                            <span>13:00 - 17:00</span>
                        </div>
                    </span >
                    <span class="w-full border-t border-dotted border-grayInput">17:00</span>
                </li> 

                <li class="w-full flex flex-col items-start gap-2">
                    <span class="w-full border-b border-dotted border-grayInput">16:00</span>
                    <span  class="w-full p-4 bg-principal3 rounded-md flex items-center gap-2 mt-2 ml-8">
                        <i class='bx bx-calendar-check text-3xl' style='color:#223249'  ></i>
                        <div class="details flex flex-col">
                            <span class="text-xl font-Urbanist font-semibold">Agendamento</span>
                            <span>13:00 - 17:00</span>
                        </div>
                    </span >
                    <span class="w-full border-t border-dotted border-grayInput">17:00</span>
                </li> 
            </ul>
    </div>
    <script type="module" src="/assets/js/agenda.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>

</main>