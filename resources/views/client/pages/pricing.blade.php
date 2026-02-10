<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Pricing List</title> -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'primary': {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            },
            'secondary': {
              50: '#fdf4ff',
              100: '#fae8ff',
              200: '#f5d0fe',
              300: '#f0abfc',
              400: '#e879f9',
              500: '#d946ef',
              600: '#c026d3',
              700: '#a21caf',
              800: '#86198f',
              900: '#701a75',
            }
          },
          animation: {
            'float': 'float 3s ease-in-out infinite',
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(-10px)' },
            }
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f9fafb;
    }

    .pricing-card:hover .pricing-check {
      color: currentColor;
    }

    .pricing-card:hover .pricing-duration {
      color: currentColor;
    }

    .pricing-popular {
      position: relative;
      overflow: hidden;
    }

    .pricing-popular::before {
      content: 'POPULAR';
      position: absolute;
      top: 26px;
      right: -26px;
      transform: rotate(45deg);
      background-color: #0ea5e9;
      color: white;
      padding: 2px 28px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1px;
      z-index: 1;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
  <div class="w-full max-w-7xl mx-auto">
    <!-- Pricing Header -->
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Choose Your Perfect Plan</h2>
      <p class="max-w-2xl mx-auto text-gray-600 text-lg">Select the best pricing option for your needs. All plans include a 14-day money-back guarantee.</p>

      <!-- Billing Toggle -->
      <div class="inline-flex items-center mt-8 bg-gray-100 p-1 rounded-lg">
        <button class="px-4 py-2 rounded-md bg-white shadow text-gray-800 font-medium">Monthly</button>
        <button class="px-4 py-2 rounded-md text-gray-600 font-medium">Yearly <span class="text-xs font-normal text-primary-600 ml-1">Save 20%</span></button>
      </div>
    </div>

    <!-- Pricing Cards Container -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      <!-- Basic Plan -->
      <div class="pricing-card bg-white border border-gray-200 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-primary-300 hover:scale-105 hover:-translate-y-1">
        <div class="p-6 md:p-8">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Basic</h3>
          <p class="text-gray-600 mb-6">Perfect for small personal websites</p>

          <div class="flex items-baseline mb-8">
            <span class="text-4xl md:text-5xl font-extrabold text-gray-900">$9</span>
            <span class="pricing-duration text-gray-500 font-medium ml-2">/ month</span>
          </div>

          <button class="w-full py-3 px-6 rounded-lg border border-primary-600 text-primary-600 font-medium transition-colors duration-300 hover:bg-primary-50 mb-6">Get Started</button>

          <ul class="space-y-4 text-gray-600">
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>1 Website</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>5GB Storage</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>10,000 Monthly Visitors</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Free SSL Certificate</span>
            </li>
            <li class="flex items-start opacity-50">
              <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span>Custom Domain</span>
            </li>
            <li class="flex items-start opacity-50">
              <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span>24/7 Support</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Pro Plan (Popular) -->
      <div class="pricing-card pricing-popular bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl shadow-lg text-white transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:-translate-y-1">
        <div class="p-6 md:p-8">
          <h3 class="text-xl font-bold mb-2">Pro</h3>
          <p class="text-primary-100 mb-6">For professional websites & small businesses</p>

          <div class="flex items-baseline mb-8">
            <span class="text-4xl md:text-5xl font-extrabold">$29</span>
            <span class="pricing-duration text-primary-100 font-medium ml-2">/ month</span>
          </div>

          <button class="w-full py-3 px-6 rounded-lg bg-white text-primary-700 font-medium transition-colors duration-300 hover:bg-primary-50 mb-6">Get Started</button>

          <ul class="space-y-4 text-white">
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-white mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>10 Websites</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-white mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>30GB Storage</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-white mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>100,000 Monthly Visitors</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-white mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Free SSL Certificate</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-white mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Custom Domain</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-white mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>24/7 Support</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Enterprise Plan -->
      <div class="pricing-card bg-white border border-gray-200 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-primary-300 hover:scale-105 hover:-translate-y-1">
        <div class="p-6 md:p-8">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Enterprise</h3>
          <p class="text-gray-600 mb-6">For large businesses & high traffic sites</p>

          <div class="flex items-baseline mb-8">
            <span class="text-4xl md:text-5xl font-extrabold text-gray-900">$79</span>
            <span class="pricing-duration text-gray-500 font-medium ml-2">/ month</span>
          </div>

          <button class="w-full py-3 px-6 rounded-lg border border-primary-600 text-primary-600 font-medium transition-colors duration-300 hover:bg-primary-50 mb-6">Get Started</button>

          <ul class="space-y-4 text-gray-600">
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Unlimited Websites</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>100GB Storage</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Unlimited Monthly Visitors</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Free SSL Certificate</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Custom Domain</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>24/7 Priority Support</span>
            </li>
            <li class="flex items-start">
              <svg class="pricing-check w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span>Dedicated Account Manager</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Testimonial/Trust Section -->
    <div class="mt-16 md:mt-24 text-center">
      <div class="flex flex-wrap justify-center gap-6 md:gap-10 mb-8">
        <img src="/api/placeholder/120/40" alt="Company Logo" class="h-8 opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-300" />
        <img src="/api/placeholder/120/40" alt="Company Logo" class="h-8 opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-300" />
        <img src="/api/placeholder/120/40" alt="Company Logo" class="h-8 opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-300" />
        <img src="/api/placeholder/120/40" alt="Company Logo" class="h-8 opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-300" />
        <img src="/api/placeholder/120/40" alt="Company Logo" class="h-8 opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-300" />
      </div>

      <p class="text-gray-600 max-w-2xl mx-auto">Trusted by over 10,000+ customers worldwide</p>
    </div>

    <!-- FAQ Section Toggle -->
    <div class="mt-16 text-center">
      <button class="text-primary-600 font-medium flex items-center mx-auto hover:text-primary-700 transition-colors duration-300">
        <span>See frequently asked questions</span>
        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
    </div>
  </div>

  <script>
    // Toggle between monthly and yearly pricing
    const toggleButtons = document.querySelectorAll('.inline-flex button');

    toggleButtons.forEach((button, index) => {
      button.addEventListener('click', () => {
        // Remove active class from all buttons
        toggleButtons.forEach(btn => {
          btn.classList.remove('bg-white', 'shadow', 'text-gray-800');
          btn.classList.add('text-gray-600');
        });

        // Add active class to clicked button
        button.classList.add('bg-white', 'shadow', 'text-gray-800');
        button.classList.remove('text-gray-600');

        // Toggle pricing
        const prices = ['$9', '$29', '$79'];
        const yearlyPrices = ['$7', '$23', '$63'];
        const priceElements = document.querySelectorAll('.text-4xl.md\\:text-5xl');

        priceElements.forEach((el, i) => {
          if (index === 0) { // Monthly
            el.textContent = prices[i];
          } else { // Yearly
            el.textContent = yearlyPrices[i];
          }
        });

        // Toggle duration text
        const durationElements = document.querySelectorAll('.pricing-duration');

        durationElements.forEach(el => {
          if (index === 0) { // Monthly
            el.textContent = '/ month';
          } else { // Yearly
            el.textContent = '/ month, billed annually';
          }
        });
      });
    });
  </script>
<!-- </body>
</html> -->
