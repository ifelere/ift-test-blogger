
@unless (empty($stat->number_of_blogs))
<div class="bg-white p-4 w-full">
    <h4 class="text-center border-b border-slate-700 mb-4">
        Publish Stats
    </h4>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4">
        <div class="rounded drop-shadow border border-slate-800">
            <div class="p-2">
                <h4 class="text-lg md:text-xl">
                    Number of Blogs
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold text-4xl">
                    {{ $stat->number_of_blogs }}
                </div>
            </div>


            @if ($stat->latest_publish_date == $stat->earliest_publish_date)
            <div class="p-2">
                <h4 class="text-lg md:text-xl">
                    Latest
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold text-4xl">
                    {{ $stat->latest_publish_date->format('M d, Y') }}
                </div>
            </div>

            @else
            <div class="p-2">
                <h4 class="text-lg md:text-xl">
                    Earliest
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold text-4xl">
                    {{ $stat->earliest_publish_date->format('M d, Y') }}
                </div>
            </div>

            <div class="p-2">
                <h4 class="text-lg md:text-xl">
                    Latest
                </h4>
                <div class="text-indigo-900 w-full flex flex-col justify-center items-center font-bold text-4xl">
                    {{ $stat->latest_publish_date->format('M d, Y') }}
                </div>
            </div>
            @endif

            
        </div>

    </div>
</div>
@endunless