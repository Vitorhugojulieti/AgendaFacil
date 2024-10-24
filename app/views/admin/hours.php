  <!-- campo -->
  <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursMorningStart" >Horario de funcionamento *inicio*manhã</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursMorningStart" id="inputOpeningHoursMorningStart" value="<?php echo old('openingHoursMorningStart') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " ></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursMorningEnd" >Horario de funcionamento *final*manhã</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursMorningEnd" id="inputOpeningHoursMorningEnd" value="<?php echo old('openingHourssMorningEnd') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursMorningError"><?php echo flash('openingHoursMorningStart');  ?><?php echo flash('openingHourssMorningEnd');  ?></span>
                                </div>
                            </div>










 <!-- campo -->
 <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursAfternoonStart" >Horario de funcionamento *inicio*tarde</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursAfternoonStart" id="inputOpeningHoursAfternoonStart" value="<?php echo old('openingHoursAfternoonStart') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " ></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursAfternoonEnd" >Horario de funcionamento *final*tarde</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursAfternoonEnd" id="inputOpeningHoursAfternoonEnd" value="<?php echo old('openingHoursAfternoonEnd') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursAfternoonError"><?php echo flash('openingHoursAfternoonStart');  ?><?php echo flash('openingHoursAfternoonEnd');  ?></span>
                                </div>




























         