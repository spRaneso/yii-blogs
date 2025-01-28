<?php

use yii\db\Migration;
use yii\helpers\Inflector;

/**
 * Handles the creation of table `{{%seed_blogs}}`.
 */
class m250127_033641_create_seed_blogs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $userIds = [2, 3, 4, 5];
        $currentTimestamp = time();

        $blogContents = [
            '<div style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
                <h1 style="color: #0066cc;">Understanding Artificial Intelligence</h1>
                <p style="color: #333;">Artificial Intelligence (AI) is a rapidly growing field of computer science that focuses on creating machines capable of performing tasks that normally require human intelligence.</p>
                <p style="color: #333;">From machine learning to natural language processing, AI is transforming industries worldwide.</p>
            </div>',
            '<div style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
                <h1 style="color: #0066cc;">Quantum Computing: The Future of Technology</h1>
                <p style="color: #333;">Quantum computing utilizes the principles of quantum mechanics to process information in ways that traditional computers cannot. It holds the promise to revolutionize fields like cryptography and complex problem solving.</p>
                <p style="color: #333;">While still in its early stages, quantum computing could pave the way for breakthroughs in medicine, finance, and material science.</p>
            </div>',
            '<div style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
                <h1 style="color: #0066cc;">The Rise of Cybersecurity in the Digital Age</h1>
                <p style="color: #333;">As more businesses and individuals move their data online, cybersecurity has become an essential part of protecting sensitive information. New technologies and strategies are being developed to combat the increasing number of cyber threats.</p>
            </div>',
            '<div style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
                <h1 style="color: #0066cc;">The Role of Biotechnology in Medicine</h1>
                <p style="color: #333;">Biotechnology is playing a key role in advancing healthcare by enabling the development of new treatments and therapies. From gene editing to personalized medicine, the impact of biotechnology in medicine is profound.</p>
            </div>',
        ];

        $images = [
            'ai.jpeg',
            'b.jpg',
            'bb.jpg',
            'bd.jpg',
            'cc.png',
            'cs.jpg',
            'dna.jpg',
            'f.jpg',
            'qc.jpg',
        ];

        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $title = 'Blog Post ' . ($i + 1);
            $slug = Inflector::slug($title);
            $userId = $userIds[array_rand($userIds)];
            $content = $blogContents[array_rand($blogContents)];
            $approvedAt = date('Y-m-d H:i:s', rand($currentTimestamp - 365 * 24 * 60 * 60, $currentTimestamp));
            $imagePath = '/uploads/blogs/' . $images[array_rand($images)];

            $data[] = [
                'user_id' => $userId,
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'status' => 'approved',
                'image_path' => $imagePath,
                'approved_by' => 1,
                'approved_at' => $approvedAt,
            ];
        }

        $this->batchInsert('blogs', ['user_id', 'title', 'slug', 'content', 'status', 'image_path', 'approved_by', 'approved_at'], $data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blogs');
    }
}
