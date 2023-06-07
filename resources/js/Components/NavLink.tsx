const NavBar = () => {
    return (
        <nav className="bg-gray-800 shadow-sm fixed top-0 left-0 w-full z-10">
            <div className="px-4 py-4 ">
                <ul className="flex items-center">
                    <li className="mr-auto">
                        <a
                            className="text-white inline-block pt-1 pb-1 mr-4 text-lg whitespace-nowrap"
                            href="/login"
                        >
                            ColoredCow Campaign
                        </a>
                    </li>
                    <li className="ml-auto">
                        <a className="text-white py-4" href="/login">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    );
};

export default NavBar;
