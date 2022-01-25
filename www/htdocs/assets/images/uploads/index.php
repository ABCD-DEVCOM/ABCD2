<?php
//Github deletes empty folders. The existence of this file prevents this 

function randomBowie() {
    $names = array(

'I, I will be king
And you, you will be queen
Though nothing will drive them away
We can beat them, just for one day
We can be heroes, just for one day',

'And you, you can be mean
And I, I´ll drink all the time
´Cause we´re lovers, and that is a fact
Yes we´re lovers, and that is that
Though nothing will keep us together
We could steal time just for one day
We can be heroes for ever and ever
What d`you say?',

'I, I wish you could swim
Like the dolphins, like dolphins can swim
Though nothing, nothing will keep us together
We can beat them, for ever and ever
Oh we can be Heroes, just for one day',

'I, I will be king
And you, you will be queen
Though nothing will drive them away
We can be Heroes, just for one day
We can be us, just for one day',

'I, I can remember (I remember)
Standing, by the wall (by the wall)
And the guns, shot above our heads (over our heads)
And we kissed, as though nothing could fall (nothing could fall)
And the shame, was on the other side
Oh we can beat them, for ever and ever
Then we could be Heroes, just for one day',

'We can be Heroes
We can be Heroes
We can be Heroes
Just for one day
We can be Heroes',

'We`re nothing, and nothing will help us
Maybe we`re lying, then you better not stay
But we could be safer, just for one day

Oh-oh-oh-ohh, oh-oh-oh-ohh, just for one day'

    );
    return $names[rand ( 0 , count($names) -1)];
}


echo '<pre>'.randomBowie().'</pre>';

?>