import Notification from "./Notification";

const { addFilter } = wp.hooks;

addFilter( 'jet.engine.register.notifications', 'jet-engine', notifications => {
	notifications.push( Notification );

	return notifications;
} )