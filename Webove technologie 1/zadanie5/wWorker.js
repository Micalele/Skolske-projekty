onmessage = function (e) {
    let from = e.data[0];
    let to = e.data[1];
    let post = [];
    console.dir(from);
    console.dir(to);

    let i = from;

    for(i; i<=to; i++){
        console.dir("wtf?");
        if(isPrime(i)) post[0] = i;
        post[1] = i;
        postMessage(post)
    }
    close();
};

function isPrime(e){
    if (e < 1) return false;

    for (let i = 2; i <= Math.sqrt(e); i++){
        if (e % i === 0){
            return false;
        }
    }
    return true;
}