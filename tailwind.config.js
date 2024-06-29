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
      'errorColor':'#FD837C',
      'sucessColor':'#22C55E',
      'black':"#000000",
      'white':"#ffff",
      'lightGray':"#E5E9EB",
      'text-gray':"#71717A",
      'transparent':'transparent'
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

