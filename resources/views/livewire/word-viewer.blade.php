<div>
    <h1>{{$current->word}} - amount {{$current->count}}</h1>
    <p wire:loading>
        Loading Description
    </p>
    <br>
    <br>
    <p wire:loading.remove>{{$current->description}}</p>
    <button wire:loading.attr="disabled" id="generate" wire:click="generateDescription">Generate description</button>
    <button id="next" wire:click="next">Next</button>
    <script>
        {{--if (!"{{$current->description}}") {--}}
        {{--    setTimeout(() => {--}}
        {{--        clickWhenEnabled().then((btn) => {--}}
        {{--            btn.click();--}}
        {{--            setTimeout(()=>{--}}
        {{--                clickWhenEnabled().then(()=>{--}}
        {{--                    document.location.reload();--}}
        {{--                })--}}
        {{--            }, 1000)--}}
        {{--        })--}}
        {{--    }, 500);--}}
        {{--}--}}

        function clickWhenEnabled() {
            let interval = {};
            console.log('checking');
            return new Promise((resolve) => {
                interval = setInterval(() => {
                    if (!document.getElementById('generate').disabled) {
                        console.log('resolving');
                        clearInterval(interval);
                        resolve(document.getElementById('generate'));
                    }
                })
            })
        }
    </script>
</div>
