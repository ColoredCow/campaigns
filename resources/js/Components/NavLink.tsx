interface NavBarProps {
    showLoginText: boolean;
    children?: React.ReactNode;
  }
  
  const NavBar = ({ showLoginText, children }: NavBarProps) => {
    return (
      <nav className="bg-gray-800 shadow-sm fixed top-0 left-0 w-full">
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
              {showLoginText ? (
                <a className="text-white py-4" href="/login">
                  Login
                </a>
              ) : (
                <a className="text-white py-4" href="/create-user">
                  Create User
                </a>
              )}
            </li>
          </ul>
        </div>
        {children}
      </nav>
    );
  };
  
  export default NavBar;
  