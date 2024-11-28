<!-- <div class="modal" id="visualizador-firmas">
	<div class="modal-background"></div>
	<div class="modal-content" id="">
		
	<div class="is-centered">
		<button type="button" class="button load-more-signs" id="load-more-signs">+</button>
	</div>
	</div>
	<button class="modal-close is-large" id="visualizador-close" aria-label="close"></button>
</div> -->

<div id="visualizador-firmas" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex bg-black opacity-50 backdrop-blur-sm">
    <!-- <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm"></div> -->

    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                    Firmas y comentarios
                </h3>
                <button type="button" id="visualizador-close" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="firma">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5" id="contenedor-firmas">
				
				
			</div>
			<button type="button" id="load-more-signs" class="text-black inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="confirmar-firma">
				Cargar más
			</button>   
                    
            </div>
        </div>
    </div>
</div> 

<!-- ========================= Formato Firma ============================= -->
				<!-- <div class='flex w-full flex-row items-start justify-start gap-3 p-4'>
					<div class='bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 shrink-0' style='background-image: url(`https://cdn.usegalileo.ai/stability/68ff76ca-1aba-4b55-ba65-c1514d03a286.png`);'></div>
					<div class='flex h-full flex-1 flex-col items-start justify-start'>
						<div class='flex w-full flex-row items-start justify-start gap-x-3'>
							<p class='text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]'>Lorelei</p>
							<p class='text-[#637588] text-sm font-normal leading-normal'>3h</p>
						</div>
						<p class='text-[#111418] text-sm font-normal leading-normal'>I'm so proud of her, she's really doing it</p>
						<div class='flex w-full flex-row items-center justify-start gap-9 pt-2'>
							<div class='flex items-center gap-2'>
							<div class='text-[#637588]' data-icon='ThumbsUp' data-size='20px' data-weight='regular'>
								<svg xmlns='http://www.w3.org/2000/svg' width='20px' height='20px' fill='currentColor' viewBox='0 0 256 256'>
								<path
									d='M234,80.12A24,24,0,0,0,216,72H160V56a40,40,0,0,0-40-40,8,8,0,0,0-7.16,4.42L75.06,96H32a16,16,0,0,0-16,16v88a16,16,0,0,0,16,16H204a24,24,0,0,0,23.82-21l12-96A24,24,0,0,0,234,80.12ZM32,112H72v88H32ZM223.94,97l-12,96a8,8,0,0,1-7.94,7H88V105.89l36.71-73.43A24,24,0,0,1,144,56V80a8,8,0,0,0,8,8h64a8,8,0,0,1,7.94,9Z'
								></path>
								</svg>
							</div>
							<p class='text-[#637588] text-sm font-normal leading-normal'>12</p>
							</div>
						</div>
					</div>
				</div> -->
				<!-- ============================================================ -->