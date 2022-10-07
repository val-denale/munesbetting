export default function ({ $auth, redirect}) {
    if (!$auth.loggedIn || !$auth.user.data.admin) {
        return redirect({ name: 'index' })
    }
}