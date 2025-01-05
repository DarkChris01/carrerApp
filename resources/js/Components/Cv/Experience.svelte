<script>
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    export let experience;
    const a = new Date();
</script>

<div class="mt-6 text-base">
    <div class="my-1 md:flex border-b items-center justify-between">
        <div class="font-semibold text-gray-700/80 capitalize md:flex w-max">
            {experience.poste} ({new Date(experience.start).getFullYear()} - {experience.end
                ? new Date(experience.end).getFullYear()
                : "en fonction"})
        </div>

        <div class="my-1 md:my-0 text-orange-600 uppercase text-standard font-semibold">
            {experience.enterprise}
        </div>
    </div>
    <div class="my-1">
        <div class="text-gray-600">
            {experience.mission}
        </div>
    </div>
</div>
