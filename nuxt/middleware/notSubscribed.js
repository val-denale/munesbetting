export default function ({ $auth, redirect}) {
    if (!$auth.loggedIn || $auth.user.data.subscribed) {
        return redirect({ name: 'index' })
    }
}