import AppNav from './AppNav.svelte';
import AppBody from './AppBody.svelte';


const anotherNav = new AppNav({
	target: document.querySelector('#appnav')

});

const anotherBody = new AppBody({
	target: document.querySelector('#appbody'),
});

export default anotherBody;