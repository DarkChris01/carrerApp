<script>
    export let enterprise;
</script>

<div class="flex justify-center items-center text-gray-800 rounded">   
    <div class="flex items-center w-full">
        <div class="px-2 w-full lg:text-l">
            <div class="flex w-full items-center">
                <div class="w-full text-sm text-gray-600">
                    <div class="mt-4 w-full">
                        <div class="font-light text-center">
                            {enterprise.name}
                        </div>
                      
                        <div class="font-light text-center">
                            {enterprise.phone}
                        </div>
                        <div class="font-light text-center">
                            {enterprise.email}
                        </div>
                        <div class="font-light text-center">
                            {enterprise.country} ({enterprise.address})
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
