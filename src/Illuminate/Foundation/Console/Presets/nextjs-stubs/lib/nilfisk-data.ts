import { Product, ProductCategory } from '@/types/product';

// Mock data inspired by Nilfisk products
export const productCategories: ProductCategory[] = [
  {
    id: 'vacuum-cleaners',
    name: 'Vacuum Cleaners',
    description: 'Professional and domestic vacuum cleaning solutions',
    image: '/images/categories/vacuum-cleaners.jpg',
    productCount: 12,
  },
  {
    id: 'pressure-washers',
    name: 'Pressure Washers',
    description: 'High-pressure cleaning equipment for all applications',
    image: '/images/categories/pressure-washers.jpg',
    productCount: 8,
  },
  {
    id: 'scrubber-dryers',
    name: 'Scrubber Dryers',
    description: 'Automated floor cleaning machines',
    image: '/images/categories/scrubber-dryers.jpg',
    productCount: 6,
  },
];

export const featuredProducts: Product[] = [
  {
    id: 'advance-sc401-43d',
    name: 'Advance SC401 43D',
    description: 'Compact walk-behind scrubber dryer with exceptional maneuverability',
    price: 45990,
    currency: 'THB',
    image: '/images/products/advance-sc401.jpg',
    category: 'scrubber-dryers',
    features: [
      'Compact design for tight spaces',
      'Exceptional battery life',
      'Easy maintenance',
      'Quiet operation',
    ],
    specifications: {
      'Cleaning Width': '43 cm',
      'Tank Capacity': '50L / 55L',
      'Battery Life': 'Up to 3 hours',
      'Weight': '85 kg',
    },
    availability: 'in-stock',
    rating: 4.8,
    reviewCount: 24,
  },
  {
    id: 'alto-c130-4-180x',
    name: 'Alto C130.4-180X',
    description: 'Professional pressure washer with advanced features',
    price: 28990,
    currency: 'THB',
    image: '/images/products/alto-c130.jpg',
    category: 'pressure-washers',
    features: [
      'High pressure output',
      'Durable construction',
      'Easy mobility',
      'Multiple accessories',
    ],
    specifications: {
      'Max Pressure': '180 bar',
      'Flow Rate': '650 L/h',
      'Power': '3.3 kW',
      'Weight': '45 kg',
    },
    availability: 'in-stock',
    rating: 4.6,
    reviewCount: 18,
  },
  {
    id: 'vl500-75-edf',
    name: 'VL500-75 EDF',
    description: 'Industrial wet & dry vacuum with exceptional suction power',
    price: 18990,
    currency: 'THB',
    image: '/images/products/vl500.jpg',
    category: 'vacuum-cleaners',
    features: [
      'Powerful motor',
      'Large capacity tank',
      'Multi-surface cleaning',
      'Robust design',
    ],
    specifications: {
      'Motor Power': '3000W',
      'Tank Capacity': '75L',
      'Suction': '250 mbar',
      'Cable Length': '10m',
    },
    availability: 'in-stock',
    rating: 4.7,
    reviewCount: 32,
  },
];

export const getAllProducts = (): Product[] => {
  return featuredProducts;
};

export const getProductsByCategory = (categoryId: string): Product[] => {
  return featuredProducts.filter(product => product.category === categoryId);
};

export const getProductById = (id: string): Product | undefined => {
  return featuredProducts.find(product => product.id === id);
};