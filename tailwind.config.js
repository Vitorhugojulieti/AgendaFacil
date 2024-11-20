/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/views/**/*.{php,js,html}"],
  theme: {
    colors: {
      'principal1': '#F2F8FC',
      'principal2': '#E1EFF8',
      'principal3': '#CBE3F2',
      'principal4': '#A7D1E9',
      'principal5': '#7CB9DE',
      'principal6': '#5D9ED4',
      'principal7': '#4B87C7',
      'principal8': '#3F72B6',
      'principal9': '#325076',
      'principal10': '#223249',
      'iconFormColor':'#AFB6C2',
      'borderFormColor':'#868686',
      'errorColor':'#F3A29F',
      'sucessColor':'#7ED59E',
      'black':"#000000",
      'white':"#ffff",
      'lightGray':"#C1C1C1",
      'text-gray':"#71717A",
      'transparent':'transparent',
      'red':'#E22B20',
      'orange':'#FFA500',
      // ooooo
      'grayInput':'#979797',
      'lightGrayInput':'#DBDBDB',
      'placeholder':'#ababab',
      'grayNotification':'#F4F4F5',
      'graySearchInput':'#f1f1f1',
      'grayBg':'#f2f4f6',
      'bgPrincipal':'#F8F8FF',
      'yellow':'#fbec5d'
    },
    fontFamily: {
      Urbanist: ['Urbanist', 'sans'], 
      Poppins: ['Poppins', 'sans'], 
    },
    extend: {
      animation: {
        'pulse-skeleton': 'pulse-skeleton 1.5s ease-in-out infinite',
      },
      keyframes: {
        'pulse-skeleton': {
          '0%, 100%': { opacity: 1 },
          '50%': { opacity: 0.4 },
        },
      },
    },
  },
  plugins: [],
}

