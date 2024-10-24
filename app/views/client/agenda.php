<main class="flex overflow-x-hidden">
    <?php require __DIR__ . '/../includes/nav.php'; ?>
    <div class="lg:w-5/6 w-full flex lg:absolute flex-col justify-start items-start bg-white p-4 pr-6" style="left:17%; top:10%;">

        <h2 class="font-Urbanist font-semibold  text-2xl text-black w-full border-b border-b-grayInput p-2">Minha agenda</h2>
        <div class="scrolls w-full border-b border-grayInput pb-4 p-4 flex flex-col gap-2">
            <div class="w-full flex items-center gap-12 font-Poppins " id="scrollMonths"></div>
            <div class="w-full flex items-center gap-4  font-Poppins p-2" id="scrollDays"></div>
        </div>

        <ul id="listSchedules" class="schedules w-full p-4">
               
        </ul>
    </div>
    <script type="module" src="/assets/js/agenda.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>

</main>