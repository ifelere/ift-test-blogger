
@unless (empty($stat->number_of_blogs))
<div class="bg-white p-4 w-full rounded-lg">
    <h4 class="text-center border-b border-slate-700 mb-4">
        Stats
    </h4>
    <div class="">
        <div class="flex flex-row flex-wrap gap-4">
            <div class="p-2 rounded drop-shadow border border-slate-800">
                <h4 class="text-lg md:text-xl">
                    Number of Blogs
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold text-4xl">
                    {{ $stat->number_of_blogs }}
                </div>
            </div>


            @if ($stat->latest_publish_date == $stat->earliest_publish_date)
            <div class="p-2 rounded drop-shadow border border-slate-800">
                <h4 class="text-lg md:text-xl">
                    Most Recent:
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold text-4xl">
                    {{ $stat->latest_publish_date->format('M d, Y') }}
                </div>
            </div>

            @else
            <div class="p-2 rounded drop-shadow border border-slate-800">
                <h4 class="text-lg md:text-xl">
                    Earliest:
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold">
                    {{ $stat->earliest_publish_date->format('M d, Y') }}
                </div>
            </div>

            <div class="p-2 rounded drop-shadow border border-slate-800">
                <h4 class="text-lg md:text-xl">
                    Latest:
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold">
                    {{ $stat->latest_publish_date->format('M d, Y') }}
                </div>
            </div>
            @endif

            
        </div>

    </div>
</div>
@endunless