export interface Product {
  id: string;
  name: string;
  description: string;
  price: number;
  currency: string;
  image: string;
  category: string;
  features: string[];
  specifications: {
    [key: string]: string;
  };
  availability: 'in-stock' | 'out-of-stock' | 'pre-order';
  rating: number;
  reviewCount: number;
}

export interface ProductCategory {
  id: string;
  name: string;
  description: string;
  image: string;
  productCount: number;
}